<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SignInController;
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
        Route::middleware('auth:api')->get('/', [CustomersController::class, 'index']);
        Route::middleware('auth:api')->get('/{id}', [CustomersController::class, 'show']);
        Route::put('/{id}', [CustomersController::class, 'update']);
        Route::put('/{id}/status', [CustomersController::class, 'updateStatus']);
        Route::put('/{id}/password', [CustomersController::class, 'updatePassword']);
    });

    /**
     * Sign In
     */
    Route::post('/sign-in/authenticate', [SignInController::class, 'authenticate']);
    Route::get('/sign-in/authenticate', [SignInController::class, 'authenticate'])->name('login');
});
