<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;

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

// Admin Route
Route::group(['middleware' => 'App\Http\Middleware\Admin'], function () {
  Route::name('admin.')->group(function () {
    Route::get('/manage/dashboard', [AdminController::class, 'index'])->name('dashboard');
  });

  Route::name('category.')->group(function () {
    Route::get('/manage/category', [CategoryController::class, 'index'])->name('manage');
    Route::get('/manage/category/create', [CategoryController::class, 'create'])->name('create');
    Route::get('/manage/category/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/manage/category/store', [CategoryController::class, 'store'])->name('store');
    Route::put('/manage/category/update', [CategoryController::class, 'update'])->name('update');
    Route::delete('/manage/category/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
  });

  Route::name('user.')->group(function () {
    Route::get('/manage/user', [UserController::class, 'index'])->name('manage');
  });

  Route::name('order.')->group(function () {
    Route::get('/manage/order', [OrderController::class, 'index'])->name('manage');
  });

  Route::name('product.')->group(function () {
    Route::get('/manage/product', [ProductController::class, 'manage'])->name('manage');
    Route::get('/manage/product/create', [ProductController::class, 'create'])->name('create');
    Route::get('/manage/product/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('/manage/product/store', [ProductController::class, 'store'])->name('store');
    Route::post('/manage/product/imagestore', [ProductController::class, 'dropzoneStore'])->name('imagestore');
    Route::put('/manage/product/update', [ProductController::class, 'update'])->name('update');
    Route::delete('/manage/product/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
  });

  Route::name('transaction.')->group(function () {
    Route::get('/manage/transaction', [CategoryController::class, 'index'])->name('manage');
  });

  Route::name('feedback.')->group(function () {
    Route::get('/manage/feedback', [FeedbackController::class, 'index'])->name('manage');
  });
});


// E-com Routes

Route::group(['middleware' => 'App\Http\Middleware\Member'], function () {

  Route::name('wishlist.')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('index');
    // Route::get('/wishlist/create', [WishlistController::class, 'create'])->name('create');
    // Route::get('/wishlist/edit', [WishlistController::class, 'edit'])->name('edit');
    Route::post('/wishlist/store', [WishlistController::class, 'store'])->name('store');
    Route::put('/wishlist/update', [WishlistController::class, 'update'])->name('update');
    Route::delete('/wishlist/delete', [WishlistController::class, 'delete'])->name('delete');
  });

  Route::name('cart.')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('index');
    // Route::get('/cart/create', [CartController::class, 'create'])->name('create');
    // Route::get('/cart/edit', [CartController::class, 'edit'])->name('edit');
    Route::post('/cart/store', [CartController::class, 'store'])->name('store');
    Route::put('/cart/update', [CartController::class, 'update'])->name('update');
    Route::delete('/cart/delete', [CartController::class, 'delete'])->name('delete');
  });

  Route::name('transaction.')->group(function () {
    // E-Com
    Route::get('/payment', [TransactionController::class, 'create'])->name('payment');
    Route::get('/order', [TransactionController::class, 'order'])->name('order');
    Route::get('/payment/success', [TransactionController::class, 'success'])->name('success');
    Route::post('/payment/store', [TransactionController::class, 'store'])->name('store');
  });

  Route::name('history.')->group(function () {
    //
  });

  Route::name('feedback.')->group(function () {
    // Di DB namanya feedbacks
  });

  Route::name('profile.')->group(function () {
    // Apakah ini bisa disamakan langsung dengan Auth ?
  });

  Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');
});

Route::name('product.')->group(function () {
  // E-com
  Route::get('/', [ProductController::class, 'index'])->name('index');
  Route::get('/categories', [ProductController::class, 'categories'])->name('category');
  // TODO : Tambahkan parameter id di url
  Route::get('/product/detail/slug-produk-id-produk', [ProductController::class, 'show'])->name('show');
});

Route::name('search.')->group(function () {
  // E-Com
  Route::get('/search/text', [SearchController::class, 'textSearchIndex'])->name('text');
  Route::get('/search/visual', [SearchController::class, 'visualSearchIndex'])->name('visual');
  // Route::post('/payment/store', [SearchController::class, 'store'])->name('store');
});