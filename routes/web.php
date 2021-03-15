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
// index e-commerce
Route::get('/', function () {
    return view('ecommerce.index');
})->name('product.index');

// categories
Route::get('/category', function () {
    return view('ecommerce.categories');
})->name('product.category');

// product detail
Route::get('/p/slug-produk-id-produk', function () {
    return view('ecommerce.detail');
})->name('product.detail');

// cart
Route::get('/cart', function () {
    return view('ecommerce.cart');
})->name('cart');

// wishlist
Route::get('/payment', function () {
    return view('ecommerce.payment');
})->name('payment');

// wishlist
Route::get('/wishlist', function () {
    return view('ecommerce.wishlist');
})->name('wishlist');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
