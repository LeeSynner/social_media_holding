<?php

use App\Http\Controllers\Api\Product\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index'])->name('api.products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('api.products.search');
Route::get('/products/categories', [ProductController::class, 'categories'])->name('api.categories.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('api.products.show');
Route::get('/products/category/{id}', [ProductController::class, 'productsByCategory'])->name('api.category.products.index');
Route::post('/products', [ProductController::class, 'store'])->name('api.products.store');
//Route::patch('/products/{id}', [ProductController::class, 'update'])->name('api.products.update');
//Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('api.products.destroy');


