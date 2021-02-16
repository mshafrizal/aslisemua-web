<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('profile')->group(function () {
  Route::get('/personal-info', function () {
    return view('profile.personal-info');
  })->name('profile.personal-info');
  Route::get('/my-purchases', function () {
    return view('profile.my-purchases');
  })->name('profile.my-purchases');
  Route::get('/track-shipment', function () {
    return view('profile.track-shipment');
  })->name('profile.track-shipment');
  Route::get('/address', function () {
    return view('profile.address');
  })->name('profile.address');
});
