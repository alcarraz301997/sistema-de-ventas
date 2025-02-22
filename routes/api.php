<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Autenticación
Route::prefix('auth')->middleware('auth:sanctum')->group(function (){
    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
});

// Usuarios
Route::prefix('users')->middleware('auth:sanctum')->group(function (){
    Route::get('', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'store']);
    Route::put('{id}', [UserController::class, 'update']);
});

// Productos
Route::prefix('products')->middleware('auth:sanctum')->group(function (){
    Route::get('', [ProductController::class, 'index']);
    Route::get('{id}', [ProductController::class, 'show']);
    Route::post('', [ProductController::class, 'store']);
    Route::put('{id}', [ProductController::class, 'update']);
    Route::patch('{id}', [ProductController::class, 'increaseStock']);
    Route::delete('{id}', [ProductController::class, 'delete']);
});

// Ventas
Route::prefix('sales')->middleware('auth:sanctum')->group(function (){
    Route::get('report', [SalesController::class, 'report']);
    Route::post('', [SalesController::class, 'store']);
});