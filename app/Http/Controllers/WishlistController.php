<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\ProductModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    function insertProduct(Request $request) {
        try {
            $product = ProductModel::find($request->product_id);
            if (empty($product) || !$product) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No Data Found',
                    'results' => (object) []
                ]);
            }

            $wishlist = new Wishlist([
                'id' => Str::uuid(),
                'product_id' => $request->product_id,
                'customer_id' => Auth::user()->id,
                'is_selected' => true
            ]);

            if ($wishlist->save()) return response()->json([
                'status' => 200,
                'message' => 'Product successfully added to wishlist'
            ]);

            return response()->json([
                'status' => 400,
                'message' => 'Failed to add product to wishlist'
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
            if (Wishlist::where('customer_id', Auth::user()->id)->where('product_id', $request->product_id)->delete()) return response()->json([
                'status' => 200,
                'message' => 'Successfully deleted from wishlist'
            ]);

            return response()->json([
                'status' => 400,
                'message' => 'Failed to remove product from wishlist'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getWishlists() {
        try {
            $wishlists = Wishlist::with('product')->where('customer_id', Auth::user()->id)->get();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully fetched',
                'data' => $wishlists
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
