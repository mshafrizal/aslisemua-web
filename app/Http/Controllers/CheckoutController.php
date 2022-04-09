<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerAddress;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductModel;
use Illuminate\Support\Str;
use App\Services\Midtrans\CreateSnapTokenService;

class CheckoutController extends Controller {
    function checkout(Request $request) {
        try {
            $customer = Auth::user()->id; // Session User id
            $isAddressChecked = CustomerAddress::where('customer_id', $customer)->where('is_default', 1)->first();
            if (!$isAddressChecked) return response()->json([
                'status' => 400,
                'message' => 'You have to choose your address first'
            ], 400);

            // Check stock of product
            $cart = Cart::select('product_id')->where('customer_id', $customer)->get();

            $productErrors = [];
            foreach ($cart as $item) {
                $product = ProductModel::find($item->product_id);
                if (!$product->stock) $productErrors[] = $product->name;
            }

            if (count($productErrors)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Product(s) ' . implode(', ', $productErrors) . ' is out of stock'
                ], 400);
            }
            // Check stock of product

            if (!$this->validateUserBio(Auth::user())->response) {
                return response()->json([
                    'status' => 400,
                    'message' => "{$this->validateUserBio(Auth::user())->field} still need to be filled",
                    'data' => $this->validateUserBio(Auth::user())
                ], 200);
            }

            $lastOrder = Order::select('order_id')->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at', 'desc')->first();

            if (!$lastOrder) $orderId = "INV/" . date('Ymd') . "/0000001";
            else {
                $orderId = $lastOrder->order_id;
                $orderId = explode('/', $orderId);
                $orderId = $orderId[2] + 1;
                $orderId = "INV/" . date('Ymd') . "/" . str_pad($orderId, 7, '0', STR_PAD_LEFT);
            }

            $newOrder = [
                'id' => Str::uuid(),
                'order_id' => $orderId,
                'billing_name' => Auth::user()->name,
                'billing_email' => Auth::user()->email,
                'billing_phone_number' => Auth::user()->phone_number,
                'billing_zip_code' => Auth::user()->postal_code,
                'billing_address' => Auth::user()->address,
                'billing_city' => Auth::user()->city,
                'billing_district' => Auth::user()->district,
                'shipping_name' => $isAddressChecked->name,
                'shipping_phone_number' => $isAddressChecked->phone,
                'shipping_address' => $isAddressChecked->address,
                'shipping_city' => $isAddressChecked->city || null,
                'shipping_zip_code' => $isAddressChecked->postal_code || null,
                'shipping_district' => $isAddressChecked->district || null,
                'requested_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'note' => $request->note,
                'payment_status' => 'unpaid',
                'payment_method' => 'midtrans',
                'order_status' => 'waiting_for_payment',
                'shipping_status' => 'waiting_for_processed',
                'is_installment' => $request->is_installment ? '1' : '0',
                'total_installment' => $request->is_installment ? $request->total_installment : 0,
                'total_base_price' => $request->total_base_price,
                'discount_price' => $request->discount_price,
                'total_final_price' => $request->total_final_price,
                'handling_fee' => $request->is_installment ? 0 : $request->handling_fee,
            ];

            $midtrans = new CreateSnapTokenService($newOrder);
            $snapToken = $midtrans->getSnapToken();

            $newOrder['snap_token'] = $snapToken;

            $order = Order::create($newOrder);

            foreach($request->products as $product) {
                $orderDetail = [
                    'id' => Str::uuid(),
                    'order_id' => $order->order_id,
                    'product_id' => $product['id'],
                    'product_name' => $product['name'],
                    'size' => $product['size'],
                    'color' => $product['color'],
                    'gender' => $product['gender'],
                    'brand_id' => $product['brand_id'],
                    'brand_name' => $product['brand_name'],
                    'category_id' => $product['category_id'],
                    'category_name' => $product['category_name'],
                    'base_price' => $product['base_price'],
                    'discount_price' => $product['discount_price'],
                    'final_price' => $product['final_price'],
                    'image_path' => $product['image_path'],
                    'image_name' => $product['image_name'],
                    'alt_image' => $product['alt_image'] || '',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $orderDetail = OrderDetail::create($orderDetail);
                
                Cart::where('product_id', $product['id'])->delete();

                $productExist = ProductModel::find($product['id']);
                $productExist->stock = $productExist->stock - 1;
                $productExist->save();
            }
            
            return response()->json([
                'status' => 201,
                'message' => 'Order placed',
                'data' => (Object)[
                    'order_id' => $orderId,
                    'snap_token' => $snapToken
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function validateUserBio($user) {
        if (!$user) return $this->outputValidation(false, (Object)[]);
        if (!$user->name) return $this->outputValidation(false, 'name');
        if (!$user->email) return $this->outputValidation(false, 'email');
        if (!$user->phone_number) return $this->outputValidation(false, 'phone number');
        if (!$user->postal_code) return $this->outputValidation(false, 'postal code');
        if (!$user->city) return $this->outputValidation(false, 'city');
        if (!$user->district) return $this->outputValidation(false, 'district');
        if (!$user->address) return $this->outputValidation(false, 'address');

        return (Object)[
            'response' => true,
            'field' => null
        ];
    }

    protected function outputValidation($return, $field) {
        return (Object)[
            'response' => $return,
            'field' => $field
        ];
    }
}