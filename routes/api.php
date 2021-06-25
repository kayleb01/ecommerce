<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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


Route::post('/add-cart', [CartController::class, 'store'])->name('add-cart');
Route::delete('/cart/{id}/delete', [CartController::class, 'destroy']);
Route::get('/payment', [PaymentController::class, 'payment']);


// Route::get('/search', function ($id) {
//     return product;
// });



Route::get('/products', [ProductController::class, 'index']);
Route::put('/product/{product}/edit',[ProductController::class, 'update']);
Route::post('create/product', [ProductController::class, 'store'])->name('create.product');
Route::post('create/media', [MediaController::class, 'store'])->name('create.media');
Route::delete('delete/media', [MediaController::class, 'destroy'])->name('delete.media');
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/add-category', [CategoryController::class, 'store']);



Route::group(['middleware' =>'api'],function(){
    Route::group(['prefix'=>'admin'],
        function($router){
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::patch('/edit/{id}', [AuthController::class, 'update']);
    });

    Route::group(['prefix'=>'manufacturer'],
        function($router){
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::patch('/edit/{id}', [AuthController::class, 'update']);
    });

    Route::group(['prefix'=>'retailer'],
        function($router){
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::patch('/edit/{id}', [AuthController::class, 'update']);
    });

    Route::group(['prefix'=>'user'],
        function($router){
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::patch('/edit/{id}', [AuthController::class, 'update']);
    });
});
