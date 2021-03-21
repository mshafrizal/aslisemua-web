<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('profile')->group(function () {
  Route::get('/personal-info', function () {
    return view('profile.personal-info');
  })->name('profile.personal-info');

  Route::get('/personal-info/edit', function () {
    return view('profile.edit-personal-info');
  })->name('profile.edit-personal-info');

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

Route::get('/sign-in', function () {
  return view('signin');
})->name('signin');

Route::get('/sign-up', function () {
  return view('signup');
})->name('signup');

// Verify Account
Route::get('/registration/verify-account/{id}', [CustomersController::class, 'sendTokenAccount']);

// Forgot Password Page
Route::get('/customers/forgot-password/{id}/edit', [CustomersController::class, 'editForgotPassword']);

Route::get('/forgot-password', function () {
  return view('forgot-password');
})->name('forgot-password');

Route::get('/forgot-password/link-sent', function () {
  return view('forgot-password-sent');
})->name('forgot-password-sent');

// Google Login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('googlesignin');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('googlecallback');

// ADMIN
// ===============

Route::prefix('admin')->group(function () {
  Route::get('/{any?}', App\Http\Controllers\AdminPagesController::class);
});