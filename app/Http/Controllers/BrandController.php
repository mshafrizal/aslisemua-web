<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandModel;

class BrandController extends Controller
{
    public function fetchBrands () {
        try {
            $brand = BrandModel::orderBy('name', 'asc')->paginate(10);
            if (!$brand) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'results' => $brand
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchBrand ($id) {
        try {
            $brand = BrandModel::find($id);
            if (empty($brand)) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => (Object) []
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'results' => $brand
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createBrand (Request $request) {
        
    }
}
