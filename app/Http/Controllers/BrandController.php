<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        try {
            $user = Auth::user();
            $name = $request->name;
            $newFileName = 'BRAND-' . $name . '-' . time() . '.' .$request->file->extension();
            $associatedProduct = 0;
            $createdBy = $user->name;
            $updatedBy = $user->name;
            $createdAt = Carbon::now();
            $updatedAt = Carbon::now();
            $filePath = '/storage/' . $request->file('file')->storeAs('brands', $newFileName, 'public');

            $newBrand = new BrandModel([
                'id' => Str::uuid(),
                'name' => $name,
                'associated_product' => $associatedProduct,
                'created_by' => $createdBy,
                'updated_by' => $updatedBy,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'file_path' => $filePath
            ]);
            // return response()->json($url = Storage::url('public/brands/'.$newFileName));
            if ($newBrand->save()) return response()->json([
                'status' => 200,
                'message' => $name . ' successfully created',
                'results' => (object)[
                    'name' => $name,
                    'file_path' => $filePath
                ]
            ]);

            $this->unlinkImage($newFileName);
            return response()->json([
                'status' => 400,
                'message' => $name . ' totally failed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function unlinkImage ($fileName) {
        Storage::delete('/public/brands/' . $fileName);
    }
}
