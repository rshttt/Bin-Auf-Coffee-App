<?php

use App\Http\Controllers\Api\UserAPIController;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

//Testing API
Route::get('/tes', [UserAPIController::class, 'tes']);

Route::post('/registration', [UserAPIController::class, 'registration']);
Route::post('/login', [UserAPIController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user() );
    Route::get('/user/favorites', [UserAPIController::class, 'favorites']);
    Route::post('/user/reset-password', [UserAPIController::class, 'resetPassword']);
    Route::post('/user/reset-profile-image', [UserAPIController::class, 'updateProfileImage']);

    Route::post('/logout', [UserAPIController::class, 'logout']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    
    Route::get('/invoices/{code}', [InvoiceController::class, 'show']);
    Route::put('/invoices/{code}', [InvoiceController::class, 'update']);
    
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
});