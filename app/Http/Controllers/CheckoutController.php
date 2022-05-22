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
use App\Models\OrderHistoryModel;
use Illuminate\Support\Arr;

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
                'requested_by' => $customer,
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

            $orderHistory = [
                'id' => Str::uuid(),
                'order_id' => $order->order_id,
                'status' => 'waiting_for_payment',
                'created_at' => now(),
                'updated_at' => now(),
                'title' => 'Pesanan berhasil di buat',
                'description' => 'Pesanan kamu telah dibuat'
            ];

            OrderHistoryModel::create($orderHistory);
            
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

    function getOrdersByCustomer($limit = null) {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            if ($limit) $data['data'] = Order::where('requested_by', Auth::user()->id)->paginate($limit);
            else $data['data'] = Order::where('requested_by', Auth::user()->id)->paginate(10);

            if (!$data['data']) return response()->json([
                'status' => 200,
                'message' => 'Orders not found',
                'data' => []
            ], 200);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getOrderDetailByCustomer(Request $request) {
        try {
            if (!isset($request->order_id)) return response()->json([
                'status' => 400,
                'message' => 'Please specify order id',
                'data' => []
            ]);
            
            $order_id = $request->order_id;
            $order = Order::where('id', $order_id)->first();

            if (!$order) return response()->json([
                'status' => 200,
                'message' => 'Order not found '.$order_id,
                'data' => []
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Order found',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getOrdersByAdmin(Request $request) {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            if ($request->order_id) $data['data'] = Order::where('order_id','LIKE','%'.$request->order_id.'%')->paginate(10);
            else $data['data'] = Order::paginate(10);

            if (!$data['data']) return response()->json([
                'status' => 200,
                'message' => 'Orders not found',
                'data' => []
            ], 200);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getOrderHistory(Request $request) {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $data['data'] = OrderHistoryModel::where('order_id', $request->order_id)->get();

            if (!$data['data']) return response()->json([
                'status' => 200,
                'message' => 'Orders not found',
                'data' => []
            ], 200);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getOrderItemsByOrderId(Request $request) {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $data['data'] = Order::with('orderItem')->where('order_id', $request->order_id)->paginate($request->limit || 10);

            if (!$data['data']) return response()->json([
                'status' => 200,
                'message' => 'Order details not found',
                'data' => []
            ], 200);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function cancelOrder(Request $request) {
        try {
            $data = [
                'status' => 200,
                'message' => 'Order Cancelled',
            ];

            $order = Order::where('order_id', $request->order_id)->first();
            $order->order_status = 'cancelled';
            $order->payment_status = 'cancelled';
            $order->shipping_status = 'cancelled';
            $order->canceled_at = now();
            $order->canceled_by = Auth::user()->id;
            $order->save();

            $orderHistory = [
                'id' => Str::uuid(),
                'order_id' => $order->order_id,
                'status' => 'cancelled',
                'created_at' => now(),
                'updated_at' => now(),
                'title' => 'Pembatalan pemesanan',
                'description' => 'Pesanan kamu telah dibatalkan'
            ];

            OrderHistoryModel::create($orderHistory);

            $products = OrderDetail::where('order_id', $order->order_id)->get();

            foreach ($products as $product) {
                $productExist = ProductModel::find($product->product_id);
                $productExist->stock = $productExist->stock + 1;
                $productExist->save();
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function updateOrderStatus(Request $request) {
        try {
            $data = [
                'status' => 200,
                'message' => 'Order Status Updated',
            ];

            $order = Order::where('order_id', $request->order_id)->first();
            $order->order_status = $request->order_status;
            $order->shipping_status = $request->shipping_status;

            $title = '';
            $message = '';
            if ($request->order_status === 'on_delivery') {
                $order->delivery_at = now();
                $order->delivery_by = Auth::user()->id;

                $title = 'Pesanan sedang dikirim';
                $message = 'Pesanan kamu sedang dikirim';
            } else if ($request->order_status === 'delivered') {
                $order->delivered_at = now();
                $order->delivered_by = Auth::user()->id;

                $title = 'Pesanan telah diterima';
                $message = 'Pesanan kamu telah diterima';
            }

            if ($order->save()) {
                $orderHistory = [
                    'id' => Str::uuid(),
                    'order_id' => $order->order_id,
                    'status' => $request->order_status,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'title' => $title,
                    'description' => $message
                ];
    
                OrderHistoryModel::create($orderHistory);
    
                return response()->json($data, 200);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Order Status Not Updated',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getOrderRevenue() {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $data['data'] = Order::selectRaw('sum(total_final_price) as total_price, count(order_status) as order_status')->where('order_status', 'delivered')->first();
            return response()->json($data, 200);
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