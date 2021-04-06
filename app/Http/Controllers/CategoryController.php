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
            $categories = CategoryModel::with(['subCategory.category', 'subCategory.furtherSubCategory']);

            if (!$categories) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            return CategoryResource::collection($categories->paginate(10))->additional($data)->response();
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
            if (empty($category) || !$categoryExisting) return response()->json([
                'status' => 200,
                'message' => 'No Data Found',
                'results' => (object) []
            ]);

            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];
            return (new CategoryResource($category->loadMissing('subCategory.furtherSubCategory')))->additional($data);
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
            $parents = $request->parents;
            $parentsArray = ($parents !== '') ? explode('|', $parents):NULL;
            $newCategory = (object)[];

            if (gettype($parents) === 'NULL') {
                $newCategory = new CategoryModel([
                    'id' => Str::uuid(),
                    'name' => $name,
                    'description' => $description,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'file_path' => $filePath,
                    'is_parent' => 1,
                    'is_published' => 1,
                    'created_by' => $createdBy,
                    'updated_by' => $updatedAt
                ]);    
            } else if (count($parentsArray) === 1) {
                $categoryExisting = CategoryModel::find($parentsArray[0]);
                if (!$categoryExisting || empty($categoryExisting)) {
                    $this->unlinkImage($newFileName);
                    return response()->json([
                        'status' => 200,
                        'message' => 'No Data Found',
                        'results' => (object) []
                    ]);
                }
                $newCategory = new SubCategoryModel([
                    'id' => Str::uuid(),
                    'name' => $name,
                    'description' => $description,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'file_path' => $filePath,
                    'parent' => $categoryExisting->name,
                    'is_published' => 1,
                    'category_id' => $categoryExisting->id,
                    'created_by' => $createdBy,
                    'updated_by' => $updatedAt
                ]);
            } else if (count($parentsArray) === 2) {
                $categoryExisting = CategoryModel::find($parentsArray[0]);
                if (!$categoryExisting || empty($categoryExisting)) {
                    $this->unlinkImage($newFileName);
                    return response()->json([
                        'status' => 200,
                        'message' => 'No Data Found',
                        'results' => (object) []
                    ]);
                }

                $subCategoryExisting = SubCategoryModel::find($parentsArray[1]);
                if (!$categoryExisting || empty($subCategoryExisting)) {
                    $this->unlinkImage($newFileName);
                    return response()->json([
                        'status' => 200,
                        'message' => 'No Data Found',
                        'results' => (object) []
                    ]);
                }

                $newCategory = new FurtherSubCategoryModel([
                    'id' => Str::uuid(),
                    'name' => $name,
                    'description' => $description,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                    'file_path' => $filePath,
                    'parent' => $subCategoryExisting->name,
                    'is_published' => 1,
                    'subcategory_id' => $subCategoryExisting->id,
                    'created_by' => $createdBy,
                    'updated_by' => $updatedAt
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Sorry the category level is 3 level only',
                    'results' => (object)[]
                ]);
            }

            if ($newCategory->save()) return response()->json([
                'status' => 200,
                'message' => $name . ' successfully created',
                'results' => (object) [
                    'name' => $name,
                    'file_path' => $filePath
                ]
            ]);

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

    public function updateCategory($id, Request $request) {

    }

    public function deleteCategory($category_id = null, $subcategory_id = null, $further_subcategory_id = null) {
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

            if ($subcategory_id !== null) {
                $categoryExisting = SubCategoryModel::find($subcategory_id);
                if (!$categoryExisting) return response()->json([
                    'status' => 400,
                    'message' => 'Subcategory not found'
                ]);
            }

            if ($further_subcategory_id !== null) {
                $categoryExisting = SubCategoryModel::find($subcategory_id);
                if (!$categoryExisting) return response()->json([
                    'status' => 400,
                    'message' => 'Subcategory not found'
                ]);

                $categoryExisting = FurtherSubCategoryModel::find($further_subcategory_id);
                if (!$categoryExisting) return response()->json([
                    'status' => 400,
                    'message' => 'Further Subcategory not found'
                ]);
            }

            $oldFilePath = $categoryExisting->file_path;
            $name = $categoryExisting->name;

            $categoryPrefix = 'categories/';
            $prefixLength = strlen($categoryPrefix);
            if (is_null($subcategory_id) && is_null($further_subcategory_id)) {
                $subCategoryByCategoryId = SubCategoryModel::where('category_id', $category_id)->get();

                if ($subCategoryByCategoryId->count() > 0) {
                    foreach ($subCategoryByCategoryId as $row) {
                        $furtherSubCategoryBySubCategoryId = FurtherSubCategoryModel::where('subcategory_id', $row->id)->get();
                        if ($furtherSubCategoryBySubCategoryId->count() > 0) {
                            foreach ($furtherSubCategoryBySubCategoryId as $val) {
                                $deleteFurtherSubCategory = FurtherSubCategoryModel::find($val->id);
                                if ($deleteFurtherSubCategory->delete()) {
                                    $oldFurtherSubCategoryPath = $val->file_path;
                                    $oldName = $val->name;
            
                                    $oldFurtherSubCategoryFileName = '';
            
                                    if (substr($oldFurtherSubCategoryPath, 0, $prefixLength) === $categoryPrefix) {
                                        $oldFurtherSubCategoryFileName = substr($oldFurtherSubCategoryPath, $prefixLength);
                                        $this->unlinkImage($oldFurtherSubCategoryFileName);
                                    }
                                }
                            }
                        }

                        $deleteSubCategory = SubCategoryModel::find($row->id);
                        if ($deleteSubCategory->delete()) {
                            $oldSubCategoryPath = $row->file_path;
                            $oldName = $row->name;
    
                            $oldSubCategoryFileName = '';
    
                            if (substr($oldSubCategoryPath, 0, $prefixLength) === $categoryPrefix) {
                                $oldSubCategoryFileName = substr($oldSubCategoryPath, $prefixLength);
                                $this->unlinkImage($oldSubCategoryFileName);
                            }   
                        }
                    }
                }
            } else if (!is_null($subcategory_id) && is_null($further_subcategory_id)) {
                $furtherSubCategoryBySubCategoryId = FurtherSubCategoryModel::where('subcategory_id', $subcategory_id)->get();
                if ($furtherSubCategoryBySubCategoryId->count() > 0) {
                    foreach ($furtherSubCategoryBySubCategoryId as $row) {
                        $deleteFurtherSubCategory = FurtherSubCategoryModel::find($row->id);
                        if ($deleteFurtherSubCategory->delete()) {
                            $oldFurtherSubCategoryPath = $row->file_path;
                            $oldName = $row->name;
    
                            $oldFurtherSubCategoryFileName = '';
    
                            if (substr($oldFurtherSubCategoryPath, 0, $prefixLength) === $categoryPrefix) {
                                $oldFurtherSubCategoryFileName = substr($oldFurtherSubCategoryPath, $prefixLength);
                                $this->unlinkImage($oldFurtherSubCategoryFileName);
                            }
                        }
                    }
                }
            }
            
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

    private function unlinkImage ($fileName) {
        Storage::delete('/public/categories/' . $fileName);
    }
}
