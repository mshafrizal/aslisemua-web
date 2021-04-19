<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Http\Resources\ProductResource;
class ProductController extends Controller
{
    function getProducts() {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $products = ProductModel::with('brand','category')->paginate(10);
            if (!$products) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            return ProductResource::collection($products)->additional($data)->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    function getProduct($product_id) {
        try {
            if (!$product_id) return response()->json([
                'status' => 400,
                'message' => 'No params. Invalid!'
            ]);

            $product = ProductModel::with('brand','category')->find($product_id);
            if (empty($product) || !$product) return response()->json([
                'status' => 200,
                'message' => 'No Data Found',
                'results' => (object) []
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Fetched Successfully',
                'results' => [
                    'data' => $product
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
