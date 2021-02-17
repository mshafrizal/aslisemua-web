<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::post('/register', [CustomersController::class, 'create']);
        Route::get('/', [CustomersController::class, 'index']);
        Route::get('/{id}', [CustomersController::class, 'show']);
        Route::put('/{id}', [CustomersController::class, 'update']);
        Route::put('/{id}/status', [CustomersController::class, 'updateStatus']);
        Route::put('/{id}/password', [CustomersController::class, 'updatePassword']);
    });
});
