<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class HomeController extends Controller
{
    function getData(Request $request) {
      try {
        $newArrivalProducts = ProductModel::with('brand','category','productImage')->orderBy('created_at')->paginate(4);
        $categories = DB::table('categories')->where('parent', 'null')->get();
//        dd($categories);
        return view('index', [
          'newArrivalProducts' => $newArrivalProducts,
          'categories' => $categories->all()
        ]);
      } catch(\Exception $e) {
        return $e->getMessage();
      }
    }
}

class HomeDataModel {
  var $newArrivalProducts;
  var $categories;

  function __construct($newArrivalProducts, $categories) {
    $this->newArrivalProducts = $newArrivalProducts;
    $this->categories = $categories;
  }
}
