<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin', 'prevent-back-history'])
    ->name('admin.')
    ->group(function() {

    Route::get('/admin', fn() => view('admin.admin'));

    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::post('/categories', [CategoryController::class, 'store']);

    Route::get('/products/create', [ProductController::class, 'create']);
    Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/products', [ProductController::class, 'store']);

    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::get('/invoices/{code}/view', [InvoiceController::class, 'view']);
    Route::get('/invoices/{code}', [InvoiceController::class, 'show']);
    Route::put('/invoices/{code}', [InvoiceController::class, 'update']);
    Route::post('/invoices', [InvoiceController::class, 'store']);
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [LoginController::class, 'view'])->name('login');
    
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/dashboard/products/{id}', [ProductController::class, 'showUser']);

Route::get('/shop-reviews', [ShopReviewController::class, 'index']);
Route::get('/shop-reviews/{id}', [ShopReviewController::class, 'show']);

Route::get('/', fn() => view('dashboard'));

Route::fallback(fn() => redirect('/'));