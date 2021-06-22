<?php
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;


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


Route::get('/products', [ProductController::class, 'index']);
Route::put('/product/{product}/edit',[ProductController::class, 'update']);
Route::post('create/product', [ProductController::class, 'store'])->name('create.product');
Route::post('create/media', [MediaController::class, 'store'])->name('create.media');
Route::delete('delete/media', [MediaController::class, 'destroy'])->name('delete.media');
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/add-category', [CategoryController::class, 'store']);



