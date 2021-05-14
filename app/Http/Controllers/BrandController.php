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
            $status = $request->status;
            $filePath = $request->file('file')->storeAs('brands', $newFileName, 'public');

            $newBrand = new BrandModel([
                'id' => Str::uuid(),
                'name' => $name,
                'associated_product' => $associatedProduct,
                'created_by' => $createdBy,
                'updated_by' => $updatedBy,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'file_path' => $filePath,
                'status' => $status
            ]);

            if ($newBrand->save()) return response()->json([
                'status' => 201,
                'message' => $name . ' successfully created',
                'results' => (object)[
                    'name' => $name,
                    'file_path' => $filePath
                ]
            ], 201);

            $this->unlinkImage($newFileName);
            return response()->json([
                'status' => 400,
                'message' => $name . ' totally failed'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateBrand (Request $request, $id) {
        try {
            $brandExisting = BrandModel::find($id);
            if (empty($brandExisting)) return response()->json([
                'status' => 400,
                'message' => 'Brand not found'
            ], 400);
            $oldFilePath = $brandExisting->file_path;
            $user = Auth::user();
            $name = $request->name;
            $newFileName = 'BRAND-' . $name . '-' . time() . '.' .$request->file->extension();
            $updatedBy = $user->name;
            $updatedAt = Carbon::now();
            $filePath = $request->file('file')->storeAs('brands', $newFileName, 'public');

            // Update brand process
            $brandExisting->name = $name;
            $brandExisting->updated_at = $updatedAt;
            $brandExisting->updated_by = $updatedBy;
            $brandExisting->file_path = $filePath;
            if ($brandExisting->save()) {
                $brandPrefix = 'brands/';
                $prefixLength = strlen($brandPrefix);
                $oldFileName = '';
                if (substr($oldFilePath, 0, $prefixLength) === $brandPrefix) {
                    $oldFileName = substr($oldFilePath, $prefixLength);
                    $this->unlinkImage($oldFileName);
                }

                return response()->json([
                    'status' => 200,
                    'message' => $name . ' successfully updated',
                    'results' => (object)[
                        'name' => $name,
                        'file_path' => $filePath
                    ]
                ], 200);
            }

            $this->unlinkImage($newFileName);
            return response()->json([
                'status' => 400,
                'message' => $name . ' totally failed'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteBrand ($id) {
        try {
            $brandExisting = BrandModel::find($id);
            if (empty($brandExisting)) return response()->json([
                'status' => 400,
                'message' => 'Brand not found'
            ], 400);

            $oldFilePath = $brandExisting->file_path;
            $name = $brandExisting->name;
            if ($brandExisting->delete()) {
                $brandPrefix = 'brands/';
                $prefixLength = strlen($brandPrefix);
                $oldFileName = '';
                if (substr($oldFilePath, 0, $prefixLength) === $brandPrefix) {
                    $oldFileName = substr($oldFilePath, $prefixLength);
                    $this->unlinkImage($oldFileName);
                }

                return response()->json([
                    'status' => 200,
                    'message' => $name . ' successfully deleted'
                ], 200);
            }
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

    public function updateBrandStatus($id, Request $request) {
        try {
            $brandExisting = BrandModel::find($id);
            if (empty($brandExisting)) return response()->json([
                'status' => 400,
                'message' => 'Brand not found'
            ], 400);

            $brandExisting->status = $request->status;
            if ($brandExisting->save()) return response()->json([
                'status' => 200,
                'message' => $brandExisting->name . ' status successfully updated'
            ]);

            return response()->json([
                'status' => 400,
                'message' => $brandExisting->name . ' status totally failed'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
