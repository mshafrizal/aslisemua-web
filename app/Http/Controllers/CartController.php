<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ProductModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function insertProduct(Request $request) {
        try {
            $product = ProductModel::find($request->product_id);
            if (empty($product) || !$product) return response()->json([
                'status' => 200,
                'message' => 'No Data Found',
                'results' => (object) []
            ]);

            if ($product->stock <= 0) return response()->json([
                'status' => 400,
                'message' => 'Out of stock'
            ]);

            $cart = new Cart([
                'id' => Str::uuid(),
                'product_id' => $request->product_id,
                'customer_id' => Auth::user()->id,
                'is_selected' => true
            ]);

            if ($cart->save()) return response()->json([
                'status' => 200,
                'message' => 'Product successfully added to cart'
            ]);

            return response()->json([
                'status' => 400,
                'message' => 'Product is failed'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function removeProduct(Request $request) {
        try {
            if (Cart::where('customer_id', Auth::user()->id)->where('product_id', $request->product_id)->delete()) return response()->json([
                'status' => 200,
                'message' => 'The product successfully deleted'
            ]);

            return response()->json([
                'status' => 400,
                'message' => 'The product is failed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getCarts() {
        try {
            $carts = Cart::with('product')->where('customer_id', Auth::user()->id)->get();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetched',
                'data' => $carts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
