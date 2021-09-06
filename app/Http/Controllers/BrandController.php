<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use ImageKit\ImageKit;
use Config;

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

    public function fetchBrandsPublic () {
      try {
        $brands = BrandModel::orderBy('name', 'asc')->get();
        if (!$brands) return response()->json([
          'status' => 200,
          'message' => 'No Data Found',
          'results' => []
        ]);

        return response()->json([
          'status' => 200,
          'message' => 'Successfully fetched',
          'results' => $brands
        ],200);
      } catch (\Exception $e) {
        return response()->json([
          'status' => 500,
          'message' => 'Something went wrong',
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
            $newFileName = 'BRAND' . preg_replace('/\s+/', '', $name) . time() . '.' .$request->file->extension();
            $associatedProduct = 0;
            $createdBy = $user->name;
            $updatedBy = $user->name;
            $createdAt = Carbon::now();
            $updatedAt = Carbon::now();
            $status = $request->status;

            $imageKit = new ImageKit(
                config('imagekit.IMAGEKIT_CDN_PUBLIC_KEY'),
                config('imagekit.IMAGEKIT_CDN_PRIVATE_KEY'),
                config('imagekit.IMAGEKIT_CDN_URL')
            );

            try {
                $uploadFile = $imageKit->upload(
                    array(
                        "file" => base64_encode(file_get_contents($request->file('file'))), // required
                        "fileName" => $newFileName, // required
                        'folder' => "/Brands"
                    )
                );

            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                    'error' => $e->getMessage()
                ], 500);
            }

            $newBrand = new BrandModel([
                'id' => Str::uuid(),
                'name' => $name,
                'associated_product' => $associatedProduct,
                'created_by' => $createdBy,
                'updated_by' => $updatedBy,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'file_path' => $uploadFile->success->url,
                'status' => $status,
                'filename' => $newFileName,
                'file_id' => $uploadFile->success->fileId
            ]);

            if ($newBrand->save()) return response()->json([
                'status' => 201,
                'message' => $name . ' successfully created'
            ], 201);

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
            $oldFileId = $brandExisting->file_id;
            $user = Auth::user();
            $name = $request->name;
            $updatedBy = $user->name;
            $updatedAt = Carbon::now();

            if ($request->file) {
              $newFileName = 'BRAND' . preg_replace('/\s+/', '', $name) . time() . '.' .$request->file->extension();
              $imageKit = new ImageKit(
                  config('imagekit.IMAGEKIT_CDN_PUBLIC_KEY'),
                  config('imagekit.IMAGEKIT_CDN_PRIVATE_KEY'),
                  config('imagekit.IMAGEKIT_CDN_URL')
              );

              try {
                  $deleteFile = $imageKit->deleteFile($oldFileId);
              } catch (\Exception $e) {
                  return response()->json([
                      'status' => 500,
                      'message' => 'Something Went Wrong',
                      'error' => $e->getMessage()
                  ], 500);
              }

              try {
                  $uploadFile = $imageKit->upload(
                      array(
                          "file" => base64_encode(file_get_contents($request->file('file'))), // required
                          "fileName" => $newFileName, // required
                          'folder' => "/Brands"
                      )
                  );
              } catch (\Exception $e) {
                  return response()->json([
                      'status' => 500,
                      'message' => 'Something Went Wrong',
                      'error' => $e->getMessage()
                  ], 500);
              }

              $brandExisting->file_path = $uploadFile->success->url;
              $brandExisting->filename = $newFileName;
              $brandExisting->file_id = $uploadFile->success->fileId;
            }


            // Update brand process
            $brandExisting->name = $name;
            $brandExisting->updated_at = $updatedAt;
            $brandExisting->updated_by = $updatedBy;

            $brandExisting->save();
            return response()->json([
                'status' => 200,
                'message' => $name . ' successfully updated'
            ], 200);
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

            $oldFileId = $brandExisting->file_id;
            $name = $brandExisting->name;

            $imageKit = new ImageKit(
                config('imagekit.IMAGEKIT_CDN_PUBLIC_KEY'),
                config('imagekit.IMAGEKIT_CDN_PRIVATE_KEY'),
                config('imagekit.IMAGEKIT_CDN_URL')
            );

            try {
                $imageKit->deleteFile($oldFileId);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                    'error' => $e->getMessage()
                ], 500);
            }
            $brandExisting->delete();
            return response()->json([
                'status' => 200,
                'message' => $name . ' successfully deleted'
            ], 200);
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
