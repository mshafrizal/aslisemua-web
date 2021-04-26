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

class CategoryController extends Controller
{
    public function fetchCategories() {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $categories = CategoryModel::paginate(10);
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

    public function fetchCategory($id) {
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

    public function createCategory(Request $request) {
        try {
            $user = Auth::user();
            $name = $request->name;
            $newFileName = 'CATEGORY-' . $name . '-' . time() . '.' .$request->file->extension();
            $createdBy = 'Pandhu Wibowo';
            $updatedBy = 'Pandhu Wibowo';
            $createdAt = Carbon::now();
            $updatedAt = Carbon::now();
            $filePath = $request->file('file')->storeAs('categories', $newFileName, 'public');
            $description = $request->description;
            $parent = $request->parent;
            $newCategory = (object)[];

            $newCategory = new CategoryModel([
                'id' => Str::uuid(),
                'name' => $name,
                'description' => $description,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'file_path' => $filePath,
                'parent' => $parent,
                'is_published' => 1,
                'created_by' => $createdBy,
                'updated_by' => $updatedBy
            ]);

            if ($newCategory->save()) return response()->json([
                'status' => 201,
                'message' => $name . ' successfully created',
                'results' => (object) [
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

    public function updateCategory($category_id, Request $request) {
        try {
            if ($category_id === null || !$category_id) return response()->json([
                'status' => 400,
                'message' => 'Category should be non-empty string',
                'results' => (object)[]
            ]);

            $user = Auth::user();
            $updatedBy = $user->name;
            $name = $request->name;
            $newFileName = 'CATEGORY-' . $name . '-' . time() . '.' .$request->file->extension();
            $updatedAt = Carbon::now();
            $filePath = $request->file('file')->storeAs('categories', $newFileName, 'public');
            $description = $request->description;
            $parents = $request->parent;
            $categoryExisting = (object)[];

            $categoryExisting = CategoryModel::find($category_id);
            if (!$categoryExisting) return response()->json([
                'status' => 400,
                'message' => 'Category not found'
            ]);
            $oldFilePath = $categoryExisting->file_path;
            $categoryPrefix = 'categories/';
            $prefixLength = strlen($categoryPrefix);

            $categoryExisting->updated_at = $updatedAt;
            $categoryExisting->description = $description;
            $categoryExisting->updated_by = $updatedBy;
            $categoryExisting->name = $name;
            $categoryExisting->file_path = $filePath;
            $categoryExisting->parent = $parents;

            if ($categoryExisting->save()) {
                $oldFileName = '';
                if (substr($oldFilePath, 0, $prefixLength) === $categoryPrefix) {
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

    function bulkDelete(Request $request) {
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

    public function deleteCategory($category_id = null) {
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

            $oldFilePath = $categoryExisting->file_path;
            $name = $categoryExisting->name;

            $categoryPrefix = 'categories/';
            $prefixLength = strlen($categoryPrefix);
            
            if ($categoryExisting->delete()) {
                $oldFileName = '';
                if (substr($oldFilePath, 0, $prefixLength) === $categoryPrefix) {
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

    public function updateStatus($category_id, Request $request) {
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

    private function unlinkImage ($fileName) {
        Storage::delete('/public/categories/' . $fileName);
    }
}
