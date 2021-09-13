<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CustomerAddressController;
use App\Models\CustomerAddress;
use App\Http\Controllers\CartController;

//Access-Control-Allow-Origin: *
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

// Route::middleware('modules:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    /**
     * ==============================
     * Customers
     * ==============================
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
     * ==============================
     * Sign In
     * ==============================
     */
    Route::post('/sign-in/authenticate', [SignInController::class, 'authenticate']);
    Route::get('/sign-in/authenticate', [SignInController::class, 'authenticate'])->name('login');

    // Forgot Password
    Route::post('/forgot-password/email/send', [CustomersController::class, 'forgotPassword']);

    /**
     * ==============================
     * Brands
     * ==============================
     */
    Route::prefix('brands')->group(function () {
        Route::get('/public', [BrandController::class, 'fetchBrandsPublic']);
        Route::middleware('modules:api')->get('/', [BrandController::class, 'fetchBrands']);
        Route::middleware('modules:api')->get('/{id}', [BrandController::class, 'fetchBrand']);
        Route::middleware('modules:api')->post('/', [BrandController::class, 'createBrand']);
        Route::middleware('modules:api')->post('/{id}', [BrandController::class, 'updateBrand']);
        Route::middleware('modules:api')->delete('/{id}', [BrandController::class, 'deleteBrand']);
        Route::middleware('modules:api')->put('/{id}/status', [BrandController::class, 'updateBrandStatus']);
        Route::middleware('modules:api')->get('/search', [BrandController::class, 'searchBrands']);
        Route::middleware('modules:api')->get('/all', [BrandController::class, 'fetchAllBrands']);
    });

    /**
     * ==============================
     * Categories
     * ==============================
     */
    Route::prefix('categories')->group(function () {
        // Administrator
        Route::prefix('private')->group(function () {
            Route::middleware('modules:api')->get('/', [CategoryController::class, 'fetchCategories']);
            Route::middleware('modules:api')->get('/{id}', [CategoryController::class, 'fetchCategory']);
            Route::middleware('modules:api')->post('/', [CategoryController::class, 'createCategory']);
            Route::middleware('modules:api')->post('update/{category_id}', [CategoryController::class, 'updateCategory']);
            Route::middleware('modules:api')->post('delete/bulk', [CategoryController::class, 'bulkDelete']);
            Route::middleware('modules:api')->post('delete/{category_id}', [CategoryController::class, 'deleteCategory']);
            Route::middleware('modules:api')->put('update/status/{category_id}', [CategoryController::class, 'updateStatus']);
        });

        // Users
        Route::prefix('public')->group(function () {
            Route::get('/main', [CategoryController::class, 'fetchCategories'])->name('categories-api');
        });
    });

    /**
     * ==============================
     * Products
     * ==============================
     */
    Route::prefix('products')->group(function () {
        // Administrator
        Route::prefix('private')->group(function () {
            Route::middleware('modules:api')->get('/', [ProductController::class, 'getProducts']);
            Route::middleware('modules:api')->get('/{product_id}', [ProductController::class, 'getProduct']);
            Route::middleware('modules:api')->post('/create', [ProductController::class, 'createProduct']);
            Route::middleware('modules:api')->delete('/{product_id}/delete', [ProductController::class, 'deleteProduct']);
            Route::middleware('modules:api')->post('/{product_id}/update', [ProductController::class, 'updateProduct']);
        });

        // Users
        Route::prefix('public')->group(function () {
            Route::get('/detail/{slug}', [ProductController::class, 'getProductBySlug']);
            Route::get(
                '/main',
                [ProductController::class, 'getPublicProducts']
            );
        });
    });

    /**
     * ==============================
     * Banners
     * ==============================
     */
    Route::prefix('banners')->group(function () {
        Route::prefix('carousel')->group(function () {
        });
    });

    /**
     * ==============================
     * Payment Methods
     * ==============================
     */
    Route::prefix('payment-methods')->group(function () {
        Route::middleware('modules:api')->get('/', [PaymentMethodController::class, 'getPaymentMethods']);
        Route::middleware('modules:api')->delete('/{id}', [PaymentMethodController::class, 'deletePaymentMethod']);
        Route::middleware('modules:api')->post('/', [PaymentMethodController::class, 'createPaymentMethod']);
    });

    /**
     * ==============================
     * Customer Addresses
     * ==============================
     */
    Route::prefix('customer-address')->group(function() {
        Route::get('/{customerId}', [CustomerAddressController::class, 'getCustomerAddressesByCustomerId']);
        Route::post('/', [CustomerAddressController::class, 'createCustomerAddress']);
        Route::delete('/{customerId}/address/{addressId}/delete', [CustomerAddressController::class, 'deleteCustomerAddress']);
        Route::put('/{customerId}/address/{addressId}', [CustomerAddressController::class, 'updateCustomerAddress']);
        Route::put('/address/status', [CustomerAddressController::class, 'setCustomerAddressDefault']);
        Route::get('detail/{id}', [CustomerAddressController::class, 'getCustomerAddress']);
    });

    /**
     * ==============================
     * Carts
     * ==============================
     */
    Route::prefix('carts')->group(function() {
        Route::middleware('modules:api')->post('/store', [CartController::class, 'insertProduct']);
        Route::middleware('modules:api')->delete('/delete', [CartController::class, 'removeProduct']);
        Route::middleware('modules:api')->get('/', [CartController::class, 'getCarts']);    
    });

    /**
     * ==============================
     * Wishlists
     * ==============================
     */
    Route::prefix('wishlists')->group(function() {
        Route::middleware('modules:api')->post('/store', [CartController::class, 'insertProduct']);
        Route::middleware('modules:api')->delete('/delete', [CartController::class, 'removeProduct']);
        Route::middleware('modules:api')->get('/', [CartController::class, 'getWishlists']);    
    });
});
