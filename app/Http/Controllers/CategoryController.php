<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use App\Models\FurtherSubCategoryModel;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ImageKit\ImageKit;
use Config;

class CategoryController extends Controller
{
    public function fetchCategories(Request $request)
    {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];
            $categories = [];
            if ($request && $request->limit) $categories = CategoryModel::paginate($request->limit);
            else $categories = CategoryModel::paginate();

            if (!$categories) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            return CategoryResource::collection($categories)->additional($data)->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchCategory($id)
    {
        try {
            $categoryExisting = CategoryModel::find($id);
            if (empty($categoryExisting) || !$categoryExisting) return response()->json([
                'status' => 200,
                'message' => 'No Data Found',
                'results' => (object) []
            ]);

            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];
            return (new CategoryResource($categoryExisting))->additional($data);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createCategory(Request $request)
    {
        try {
            $user = Auth::user();
            $name = $request->name;
            $newFileName = 'CATEGORY' . preg_replace('/\s+/', '', $name) . time() . '.' .$request->file->extension();
            $createdBy = $user->name;
            $updatedBy = $user->name;
            $createdAt = Carbon::now();
            $updatedAt = Carbon::now();
            $description = $request->description;
            $parent = $request->parent;
            $newCategory = (object)[];
            $isNavbar = $request->is_navbar;

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
                        'folder' => "/Categories"
                    )
                );
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                    'error' => $e->getMessage()
                ], 500);
            }

            $newCategory = new CategoryModel([
                'id' => Str::uuid(),
                'name' => $name,
                'description' => $description,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'file_path' => $uploadFile->success->url,
                'parent' => $parent,
                'is_published' => 1,
                'created_by' => $createdBy,
                'updated_by' => $updatedBy,
                'slug' => Str::slug($name) . '-' . time(),
                'is_navbar' => $isNavbar,
                'filename' => $newFileName,
                'file_id' => $uploadFile->success->fileId
            ]);

            if ($newCategory->save()) return response()->json([
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

    public function updateCategory($category_id, Request $request)
    {
        try {
            if ($category_id === null || !$category_id) return response()->json([
                'status' => 400,
                'message' => 'Category should be non-empty string',
                'results' => (object)[]
            ]);

            $user = Auth::user();
            $updatedBy = $user->name;
            $name = $request->name;
            $newFileName = 'CATEGORY' . preg_replace('/\s+/', '', $name) . time() . '.' .$request->file->extension();
            $updatedAt = Carbon::now();
            $filePath = $request->file('file')->storeAs('categories', $newFileName, 'public');
            $description = $request->description;
            $parents = $request->parent;
            $categoryExisting = (object)[];
            $isNavbar = $request->is_navbar;

            $categoryExisting = CategoryModel::find($category_id);
            if (!$categoryExisting) return response()->json([
                'status' => 400,
                'message' => 'Category not found'
            ]);
            $oldFileId = $categoryExisting->file_id;
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
                        'folder' => "/Categories"
                    )
                );
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                    'error' => $e->getMessage()
                ], 500);
            }

            $categoryExisting->updated_at = $updatedAt;
            $categoryExisting->description = $description;
            $categoryExisting->updated_by = $updatedBy;
            $categoryExisting->name = $name;
            $categoryExisting->file_path = $uploadFile->success->url;
            $categoryExisting->parent = $parents;
            $categoryExisting->slug = Str::slug($name) . '-' . time();
            $categoryExisting->is_navbar = $isNavbar;
            $categoryExisting->filename = $newFileName;
            $categoryExisting->file_id = $uploadFile->success->fileId;

            $categoryExisting->save();

            return response()->json([
                'status' => 200,
                'message' => $name . ' successfully updated',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function bulkDelete(Request $request)
    {
        try {
            $array = [];
            $error = [];
            foreach ($request->category_ids as $row) {
                $result = $this->deleteCategory($row);
                $realResponse = json_decode($result->getContent(), true);
                if ($realResponse['status'] === 200) {
                    array_push($array, $realResponse);
                } else {
                    array_push($error, $realResponse);
                }
            }

            if (count($error) > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Category partially deleted successfully'
                ]);
            } else if (count($array) === 0) {
                return response()->json([
                    'status' => 400,
                    'message' => 'The entire category failed to delete'
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'The entire category was deleted successfully'
                ]);
            }
            return response()->json($array);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteCategory($category_id = null)
    {
        try {
            if ($category_id === null || !$category_id) return response()->json([
                'status' => 400,
                'message' => 'Category should be non-empty string',
                'results' => (object)[]
            ]);

            $categoryExisting = (object)[];

            $categoryExisting = CategoryModel::find($category_id);
            if (!$categoryExisting) return response()->json([
                'status' => 400,
                'message' => 'Category not found'
            ]);

            $imageKit = new ImageKit(
                config('imagekit.IMAGEKIT_CDN_PUBLIC_KEY'),
                config('imagekit.IMAGEKIT_CDN_PRIVATE_KEY'),
                config('imagekit.IMAGEKIT_CDN_URL')
            );

            $oldFileId = $categoryExisting->file_id;
            $name = $categoryExisting->name;

            if ($categoryExisting->delete()) {
                try {
                    $imageKit->deleteFile($oldFileId);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Something Went Wrong',
                        'error' => $e->getMessage()
                    ], 500);
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

    public function updateStatus($category_id, Request $request)
    {
        try {
            if ($category_id === null || !$category_id) return response()->json([
                'status' => 400,
                'message' => 'Category should be non-empty string',
                'results' => (object)[]
            ]);

            $categoryExisting = CategoryModel::find($category_id);
            if (!$categoryExisting) return response()->json([
                'status' => 400,
                'message' => 'Category not found'
            ]);

            $status = $request->status;

            $categoryExisting->is_published = $status;
            if ($categoryExisting->save()) return response()->json([
                'status' => 200,
                'message' => $categoryExisting->name . ' status successfully updated',
            ]);

            return response()->json([
                'status' => 400,
                'message' => $categoryExisting->name . 'status totally failed'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function unlinkImage($fileName)
    {
        Storage::delete('/public/categories/' . $fileName);
    }
}
