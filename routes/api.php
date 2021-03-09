<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\BrandController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Access-Control-Allow-Origin: *
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    /**
     * Customers
     */
    Route::prefix('customers')->group(function () {
        Route::post('/register', [CustomersController::class, 'create']);
        Route::put('/verify/{id}', [CustomersController::class, 'verifyAccount']);
        Route::middleware('auth:api')->get('/', [CustomersController::class, 'index']);
        Route::middleware('auth:api')->get('/{id}', [CustomersController::class, 'show']);
        Route::middleware('auth:api')->put('/{id}', [CustomersController::class, 'update']);
        Route::middleware('auth:api')->put('/{id}/status', [CustomersController::class, 'updateStatus']);
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
        Route::middleware('auth:api')->get('/', [BrandController::class, 'fetchBrands']);
        Route::middleware('auth:api')->get('/{id}', [BrandController::class, 'fetchBrand']);
        Route::middleware('auth:api')->post('/', [BrandController::class, 'createBrand']);
        Route::middleware('auth:api')->post('/{id}', [BrandController::class, 'updateBrand']);
        Route::middleware('auth:api')->delete('/{id}', [BrandController::class, 'deleteBrand']);
    });

    /**
     * Categories
     */
});
