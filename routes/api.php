<?php

use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/statistics', [DashboardController::class, 'index'])->middleware('auth:sanctum');
Route::resource('users', UserController::class)->middleware('auth:sanctum');
Route::get('/c/products/{slug}', [ProductController::class, 'showBySlug']); // ->where('slug', '/(?!^\d+$)^.+$/gm');
Route::post('/products/{product}/media', [ProductController::class, 'media']);
Route::delete('/products/{product}/media/{media}/', [ProductController::class, 'destroyMedia']); // By simplicity the method for media is implemented in the product controller, could have its proper controller
Route::resource('products', ProductController::class);
Route::post('/checkout', CheckoutController::class);