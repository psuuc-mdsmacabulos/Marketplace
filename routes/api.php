<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\API\ProductController;

Route::middleware(['auth:sanctum'])->group(function () {
    // Get authenticated user details
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    // Logout endpoint
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Create product (admin only)
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});

// Public routes
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

// Product routes (public)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');