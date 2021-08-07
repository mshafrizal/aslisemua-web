<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    function getProducts() {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $products = ProductModel::with('brand','category','productImage')->paginate(10);
            if (!$products) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            return ProductResource::collection($products)->additional($data)->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getProductsByQuery(Request $request) {
        try {
            $data = 'Hello world';
            return view('index', $data);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    function getPublicProducts(Request $request) {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $products = ProductModel::with('brand','category','productImage');
            if (($request && $request->start_price) && ($request && $request->end_price)) {
                if ($request->start_price > $request->end_price) return response()->json([
                    'status' => 400,
                    'message' => 'Start price could not be bigger than the end price'
                ]);
            }

            if ($request && $request->keywords) {
                $keywords = utf8_decode(urldecode($request->keywords));
                $products = $products->where('name', 'like', '%' . $keywords . '%')
                                ->orWhereHas('brand', function($q) use ($keywords) {
                                    $q->where('name', 'like', '%' . $keywords . '%');
                                });
            }

            if ($request && $request->start_price) $products = $products->where('final_price', '>=', $request->start_price); // Start price
            if ($request && $request->end_price) $products = $products->where('final_price', '<=', $request->end_price); // End price

            if ($request && $request->clothing_size) {
                $sizes = explode(',', $request->clothing_size);
                $products = $products->whereIn('size', $sizes); // Clothing Size
            }

            if ($request && $request->shoe_size) {
                $sizes = explode(',', $request->shoe_size);
                $products = $products->whereIn('size', $sizes); // Shoe Size
            }

            if ($request && $request->gender) {
                $gender = explode(',', $request->gender);
                $products = $products->whereIn('gender', $gender); // Gender
            }

            if ($request && $request->color) {
                $color = explode(',', $request->color);
                $products = $products->whereIn('color', $color); // Color
            }

            if ($request && $request->category) {
                $categories = implode(" >> ", explode(",", $request->category));
                $products = $products->whereHas('category', function($q) use ($categories){
                    $q->where('name', $categories);
                }); // Category
            }

            if ($request && $request->brand) {
                $brands = explode(",", $request->brand);
                // $products = $products->whereIn('brand', $brands)
                $products = $products->whereHas('brand', function($q) use ($brands) {
                    $q->whereIn('name', $brands);
                }); // Brand
            }

            if ($request && $request->order_by) {
                if ($request->order_by === 'desc') $products = $products->orderBy('final_price', $request->order_by);
                else $products = $products->orderBy('final_price', $request->order_by); // Order by
            }

            if ($request && $request->new_arrival === 'yes') {
                $date = \Carbon\Carbon::today()->subDays(7);
                $products = $products->where('updated_at', $date); // New Arrival
            }

            if ($request && $request->sale === 'yes') $products = $products->where('discount_price', '>', 0);

            $limit = 16;
            if ($request && (int)$request->limit > 0) $limit = $request->limit; // Set up limit

            $products = $products->where('status', true)->paginate($limit);
            if ($products->count() === 0) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            return ProductResource::collection($products)->additional($data)->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    function getProduct($product_id) {
        try {
            if (!$product_id) return response()->json([
                'status' => 400,
                'message' => 'No params. Invalid!'
            ]);

            $product = ProductModel::with('brand','category','productImage')->find($product_id);
            if (empty($product) || !$product) return response()->json([
                'status' => 200,
                'message' => 'No Data Found',
                'results' => (object) []
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Fetched Successfully',
                'results' => [
                    'data' => $product
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function demoGetProduct($product_id) {
      $data = ProductModel::with('brand','category','productImage')->find($product_id);
//      dd($data->productImage);
      return view('product.product-detail')->with('data', $data);
    }

    function getProductBySlug($slug) {
        try {
            $product = ProductModel::with('brand', 'category', 'productImage')->where('slug', $slug)->first();
            if (empty($product)) return response()->json([
                'status' => 200,
                'message' => 'No Data Found',
                'results' => (object) []
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Fetched Successfully',
                'results' => [
                    'data' => $product
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function createProduct(Request $request) {
        try {
            $brandId = $request->brand_id;
            $categoryId = $request->category_id;

            if (!$brandId) return response()->json([
                'status' => 400,
                'message' => 'Brand id not found'
            ]);

            if (!$categoryId) return response()->json([
                'status' => 400,
                'message' => 'Category id not found'
            ]);

            $brandExisting = BrandModel::find($brandId);
            if (empty($brandExisting)) return response()->json([
                'status' => 400,
                'message' => 'Brand not found'
            ]);

            $categoryExisting = CategoryModel::find($categoryId);
            if (empty($categoryExisting)) return response()->json([
                'status' => 400,
                'message' => 'Category not found'
            ]);

            if (!$request->hasFile('images')) return response()->json([
                'status' => 400,
                'message' => 'Images not found'
            ], 400);

            $allowedFileExtension = ['jpeg', 'jpg', 'png'];
            $images = $request->file('images');
            $errors = [];
            $arrImages = [];

            $name = $request->name;
            $size = $request->size;
            $gender = $request->gender;
            $color = $request->color;
            $condition = $request->condition;
            $description = $request->description;
            $detail = $request->detail;
            $discountPrice = $request->discount_price;
            $altImage = $request->alt_image;
            $basePrice = $request->base_price;
            $finalPrice = $request->final_price;
            $stock = $request->stock;
            // $user = Auth::user();
            $user = 'Pandhu Wibowo';
            foreach($images as $image) {
                $newFileName = 'PRODUCT'. time(). '-' . $image->getClientOriginalName();
                $image->storeAs('products', $newFileName, 'public');
                $arrImages[] = $newFileName;
            }
            $now = Carbon::now();
            $productImage = [];
            $newProductImage = [];

            $newProduct = new ProductModel([
                'id' => Str::uuid(),
                'name' => $name,
                'size' => $size,
                'gender' => $gender,
                'color' => $color,
                'condition' => $condition,
                'description' => $description,
                'detail' => $detail,
                'discount_price' => $discountPrice,
                'alt_image' => $altImage,
                'base_price' => $basePrice,
                'final_price' => $finalPrice,
                'brand_id' => $brandId,
                'category_id' => $categoryId,
                'image_path' => 'products/' . $arrImages[0],
                'image_name' => $arrImages[0],
                'status' => true,
                'created_by' => $user,
                'updated_by' => $user,
                'created_at' => $now,
                'updated_at' => $now,
                'stock' => $stock,
                'slug' => Str::slug($name) . '-' . time()
            ]);

            if ($newProduct->save()) {
                foreach($arrImages as $image) {
                    $productImage = [
                        'id' => Str::uuid(),
                        'product_id' => $newProduct->id,
                        'image_path' => 'products/' . $image,
                        'image_name' => $image,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    $newProductImage[] = $productImage;
                }

                ProductImageModel::insert($newProductImage);
                return response()->json([
                    'status' => 201,
                    'message' => $name . ' successfully created',
                ], 201);
            }

            foreach($arrImages as $image) {
                $this->unlinkImage($image);
            }

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

    function deleteProduct($id) {
        try {
            if (!$id) return response()->json([
                'status' => 400,
                'message' => 'Product id not found'
            ]);

            $productExisting = ProductModel::find($id);
            if (empty($productExisting)) return response()->json([
                'status' => 400,
                'message' => 'Product not found'
            ]);

            $productImageExisting = ProductImageModel::where('product_id', $id)->get();
            if (count($productImageExisting) > 0) ProductImageModel::whereIn('product_id', [$id])->delete();

            if (count($productImageExisting) > 0) {
                foreach($productImageExisting as $row) {
                    $this->unlinkImage($row->image_name);
                }
            }
            $productExisting->delete();
            return response()->json([
                'status' => 200,
                'message' => $productExisting->name . ' successfully deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function updateProduct($id, Request $request) {
        try {
            if (!$id) return response()->json([
                'status' => 400,
                'message' => 'Product id not found'
            ]);
            $productExisting = ProductModel::find($id);
            if (empty($productExisting)) return response()->json([
                'status' => 400,
                'message' => 'Product not found'
            ]);

            $brandId = $request->brand_id;
            $categoryId = $request->category_id;

            if (!$brandId) return response()->json([
                'status' => 400,
                'message' => 'Brand id not found'
            ]);

            if (!$categoryId) return response()->json([
                'status' => 400,
                'message' => 'Category id not found'
            ]);

            $brandExisting = BrandModel::find($brandId);
            if (empty($brandExisting)) return response()->json([
                'status' => 400,
                'message' => 'Brand not found'
            ]);

            $categoryExisting = CategoryModel::find($categoryId);
            if (empty($categoryExisting)) return response()->json([
                'status' => 400,
                'message' => 'Category not found'
            ]);

            if (!$request->hasFile('images')) return response()->json([
                'status' => 400,
                'message' => 'Images not found'
            ], 400);

            $name = $request->name;
            $size = $request->size;
            $gender = $request->gender;
            $color = $request->color;
            $condition = $request->condition;
            $description = $request->description;
            $detail = $request->detail;
            $discountPrice = $request->discount_price;
            $altImage = $request->alt_image;
            $basePrice = $request->base_price;
            $finalPrice = $request->final_price;
            $stock = $request->stock;
            // $user = Auth::user();
            $user = 'Pandhu Wibowo';

            $now = Carbon::now();

            $productExisting->name = $name;
            $productExisting->size = $size;
            $productExisting->gender = $gender;
            $productExisting->color = $color;
            $productExisting->condition = $condition;
            $productExisting->description = $description;
            $productExisting->detail = $detail;
            $productExisting->discount_price = $discountPrice;
            $productExisting->alt_image = $altImage;
            $productExisting->base_price = $basePrice;
            $productExisting->final_price = $finalPrice;
            $productExisting->stock = $stock;
            $productExisting->updated_by = $user;
            $productExisting->updated_at = $now;
            $productExisting->slug = Str::slug($name) . '-' . time();

            $images = $request->file('images');
            $errors = [];
            $arrImages = [];

            // Save new Images
            foreach($images as $image) {
                $newFileName = 'PRODUCT'. time(). '-' . $image->getClientOriginalName();
                $image->storeAs('products', $newFileName, 'public');
                $arrImages[] = $newFileName;
            }
            $productExisting->image_path = 'products/' . $arrImages[0];
            $productExisting->image_name = $arrImages[0];

            if ($productExisting->save()) {
                $productsImages = ProductImageModel::where('product_id', $id)->get();
                if (count($productsImages) > 0) {
                    foreach($productsImages as $row) {
                        $this->unlinkImage($row->image_name);
                    }

                    ProductImageModel::whereIn('product_id', [$id])->delete();
                }

                foreach($arrImages as $image) {
                    $newProductImage = [
                        'id' => Str::uuid(),
                        'product_id' => $productExisting->id,
                        'image_path' => 'products/' . $image,
                        'image_name' => $image,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    $newProductsImages[] = $newProductImage;
                }

                ProductImageModel::insert($newProductsImages);

                return response()->json([
                    'status' => 200,
                    'message' => $name . ' successfully updated',
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
        Storage::delete('/public/products/' . $fileName);
    }
}
