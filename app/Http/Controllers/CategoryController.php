<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function fetchCategories() {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];
            $categories = CategoryModel::with(['subCategory.category', 'subCategory.furtherSubCategory']);
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

    }

    public function updateCategory($id, Request $request) {

    }

    public function deleteCategory($id) {

    }
}
