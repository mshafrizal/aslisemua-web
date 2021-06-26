<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ShopController extends Controller
{
  public function shopAllCategories(Request $request) {
    $data = ProductModel::where('status', 1)->simplePaginate(16);
    $brand = BrandModel::all();
    $sortedBrand = $brand->sortBy('name');
    $category = CategoryModel::where('parent', 'null')->get();
    $sortedCategory = $category->sortBy('name');
    return view('shop.shop-all-categories')->with('data', $data)->with('brands', $sortedBrand)->with('categories', $sortedCategory);
  }

  public function shopByMainCategory(Request $request, $category_slug) {
    $category = CategoryModel::where('name', $category_slug)->first();
    $brands = BrandModel::all()->sortBy('name');
    $categories = CategoryModel::all()->sortBy('name');
    $data = ProductModel::where('category_id', $category->id)->paginate(16);
//    dd($data);
    return view('shop.shop-by-main-category')->with('data', $data)->with('brands', $brands)->with('categories', $categories);
  }

  public function shopBySubCategory(Request $request, $main_category, $sub_category) {
    return view('index');
  }

  public function shopSaleItems(Request $request) {
    $data = ProductModel::where('discount_price', '>', 0)->paginate(16);
//    dd($data);
    return view('shop.shop-sale-items')->with('data', $data);
  }
}
