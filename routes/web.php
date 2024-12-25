<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CartController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//shop page
Route::get('/shop-pages', [HomeController::class, 'shop'])->name('shop');

//cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/add-to-cart', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/increase-cart-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty-increase');
Route::put('/decrease-cart-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty-decrease');
Route::delete('/remove-from-cart/{id}', [CartController::class, 'remove_from_cart'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'allClear'])->name('cart.clear');
//single product page

//single product page
Route::get('/single-product/{id}/{slug}', [HomeController::class, 'singleProduct'])->name('single-product');

Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.index');
    //brands -----------------------
    Route::get('admin-brands', [BrandController::class,'index'])->name('admin-brands.index');
    Route::get('admin-brands/create', [BrandController::class,'create'])->name('admin-brands.create');
    Route::post('admin-brands/store', [BrandController::class,'store'])->name('admin-brands.store');
    Route::get('admin-brands/{id}/edit', [BrandController::class,'edit'])->name('admin-brands.edit');
    Route::put('admin-brands/{id}/update', [BrandController::class,'update'])->name('admin-brands.update');
    Route::delete('admin-brands/{id}/delete', [BrandController::class, 'destroy'])->name('admin-brands.destroy');
});

Route::middleware(['auth', AuthAdmin::class])->prefix('admin')->group(function () {

    //categories -----------------------
    Route::get('/categories', [CategoryController::class,'index'])->name('admin.category-index');
    Route::get('/categories/create', [CategoryController::class,'create'])->name('admin.category-create');
    Route::post('/categories', [CategoryController::class,'store'])->name('admin.category-store');
    Route::get('/categories/{id}/edit', [CategoryController::class,'edit'])->name('admin.category-edit');
    Route::put('/categories/{id}', [CategoryController::class,'update'])->name('admin.category-update');
    Route::get('/categories/{id}', [CategoryController::class,'destroy'])->name('admin.category-destroy');

    //products -----------------------
    Route::get('/products', [ProductController::class,'index'])->name('admin.product-index');
    Route::get('/products/create', [ProductController::class,'create'])->name('admin.product-create');
    Route::post('/products', [ProductController::class,'store'])->name('admin.product-store');
    Route::get('/products/{id}/edit', [ProductController::class,'edit'])->name('admin.product-edit');
    Route::put('/products/{id}', [ProductController::class,'update'])->name('admin.product-update');
    Route::get('/products/{id}/show', [ProductController::class,'show'])->name('admin.product-show');
    Route::delete('/products/{id}', [ProductController::class,'destroy'])->name('admin.product-destroy');

});