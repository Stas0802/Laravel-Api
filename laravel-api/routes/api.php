<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Route on work with users
 */
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

/**
 * Route on work with products
 */
Route::middleware('auth:sanctum')->apiResource('/categories', CategoryController::class);

Route::apiResource('/products', ProductController::class);

Route::apiResource('/products.comments', CommentController::class)->middleware('auth:sanctum');
