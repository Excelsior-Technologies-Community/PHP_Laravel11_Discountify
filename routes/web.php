<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/', fn() => redirect('/cart'));

Route::get('/cart',             [CartController::class, 'index']);
Route::get('/create-product',   [CartController::class, 'create']);
Route::post('/add-product',     [CartController::class, 'store']);
Route::get('/edit/{id}',        [CartController::class, 'edit']);
Route::post('/update/{id}',     [CartController::class, 'update']);
Route::post('/update-qty/{id}', [CartController::class, 'updateQty']);
Route::get('/delete/{id}',      [CartController::class, 'delete']);
Route::get('/clear-cart',       [CartController::class, 'clear']);
Route::get('/checkout',         [CartController::class, 'checkout']);
Route::post('/place-order',     [CartController::class, 'placeOrder']);
Route::get('/order-success/{id}', [CartController::class, 'orderSuccess']);
