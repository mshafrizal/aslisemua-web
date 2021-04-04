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

    public function fetchCategory(CategoryModel $category) {
        try {
            if (empty($category)) return response()->json([
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
            $createdBy = $user->name;
            $updatedBy = $user->name;
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

    public function deleteCategory($id) {

    }

    private function unlinkImage ($fileName) {
        Storage::delete('/public/categories/' . $fileName);
    }
}
