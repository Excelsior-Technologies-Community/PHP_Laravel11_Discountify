<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart', [CartController::class, 'index']);           // Cart Details
Route::get('/create-product', [CartController::class, 'create']); // Show create form
Route::post('/add-product', [CartController::class, 'store']);    // Add product to cart
Route::get('/clear-cart', [CartController::class, 'clear']);      // Clear cart (optional)

