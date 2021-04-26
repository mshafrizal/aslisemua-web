<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

//Access-Control-Allow-Origin: *
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

// Route::middleware('modules:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    /**
     * Customers
     */
    Route::prefix('customers')->group(function () {
        Route::post('/register', [CustomersController::class, 'create']);
        Route::put('/verify/{id}', [CustomersController::class, 'verifyAccount']);
        Route::middleware('modules:api')->get('/', [CustomersController::class, 'index']);
        Route::middleware('modules:api')->get('/{id}', [CustomersController::class, 'show']);
        Route::middleware('modules:api')->put('/{id}', [CustomersController::class, 'update']);
        Route::middleware('modules:api')->put('/{id}/status', [CustomersController::class, 'updateStatus']);
        Route::put('/{id}/password', [CustomersController::class, 'updatePassword']);
    });

    /**
     * Sign In
     */
    Route::post('/sign-in/authenticate', [SignInController::class, 'authenticate']);
    Route::get('/sign-in/authenticate', [SignInController::class, 'authenticate'])->name('login');

    // Forgot Password
    Route::post('/forgot-password/email/send', [CustomersController::class, 'forgotPassword']);

    /**
     * Brand
     */
    Route::prefix('brands')->group(function () {
        Route::middleware('modules:api')->get('/', [BrandController::class, 'fetchBrands']);
        Route::middleware('modules:api')->get('/{id}', [BrandController::class, 'fetchBrand']);
        Route::middleware('modules:api')->post('/', [BrandController::class, 'createBrand']);
        Route::middleware('modules:api')->post('/{id}', [BrandController::class, 'updateBrand']);
        Route::middleware('modules:api')->delete('/{id}', [BrandController::class, 'deleteBrand']);
    });

    /**
     * Categories
     */
    Route::prefix('categories')->group(function () {
        // Administrator
        Route::prefix('private')->group(function () {
            Route::get('/', [CategoryController::class, 'fetchCategories']);
            Route::middleware('auth:api')->get('/{id}', [CategoryController::class, 'fetchCategory']);
            Route::post('/', [CategoryController::class, 'createCategory']);
            Route::middleware('auth:api')->post('update/{category_id}', [CategoryController::class, 'updateCategory']);
            Route::post('delete/bulk', [CategoryController::class, 'bulkDelete']);
            Route::middleware('auth:api')->post('delete/{category_id}', [CategoryController::class, 'deleteCategory']);
            Route::put('update/status/{category_id}', [CategoryController::class, 'updateStatus']);
        });

        // Users
        Route::prefix('public')->group(function () {
            Route::get('/{limit?}', [CategoryController::class, 'fetchCategories']);
        });
    });

    /**
     * Products
     */
    Route::prefix('products')->group(function () {
        // Administrator
        Route::prefix('private')->group(function () {
            Route::get('/', [ProductController::class, 'getProducts']);
            Route::get('/{product_id}', [ProductController::class, 'getProduct']);
            Route::post('/create', [ProductController::class, 'createProduct']);
            Route::delete('/{product_id}/delete', [ProductController::class, 'deleteProduct']);
            Route::post('/{product_id}/update', [ProductController::class, 'updateProduct']);
        });

        // Users
        Route::prefix('public')->group(function () {
            Route::get('/{slug}', [ProductController::class, 'getProductBySlug']);
        });
    });
});
