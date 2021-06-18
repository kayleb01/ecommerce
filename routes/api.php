<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('create/product', [ProductController::class, 'store'])->name('create.product');
Route::post('create/media', [MediaController::class, 'store'])->name('create.media');
Route::delete('delete/media', [MediaController::class, 'destroy'])->name('delete.media');
Route::post('/product/review', [ProductReviewController::class, 'store']);
Route::post('/review/{id}/update', [ProductReviewController::class, 'update']);
