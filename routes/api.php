<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

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
Route::post('/add-cart', [CartController::class, 'store'])->name('add-cart');
Route::delete('/cart/{id}/delete', [CartController::class, 'destroy']);
Route::get('/payment', [PaymentController::class, 'payment']);
