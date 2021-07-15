<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BillingAddressController;




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


Route::post('add/billing-address', [BillingAddressController::class, 'store']);
Route::patch('/billing-address/{billingAddress}/edit',[BillingAddressController::class, 'update']);

Route::post('/product/review', [ProductController::class, 'review']);
Route::post('/review/{id}/update', [ProductReviewController::class, 'update']);

Route::get('/products', [ProductController::class, 'index']);
Route::put('/product/{product}/edit',[ProductController::class, 'update']);
Route::post('create/product', [ProductController::class, 'store'])->name('create.product');
Route::post('create/media', [MediaController::class, 'store'])->name('create.media');
Route::delete('delete/media', [MediaController::class, 'destroy'])->name('delete.media');

// List all your categories
Route::get('/categories', [CategoryController::class, 'index']);
//Create your Category
Route::post('/add-category', [CategoryController::class, 'store']);
//View Each category details
Route::get('/view-category/{category}', [CategoryController::class, 'show']);



//Search for category
Route::get('/search-category/{name}', [CategoryController::class, 'search']);

//Search for likely product
Route::get('/{name}', [ProductController::class, 'search']);

Route::group(['middleware' =>'api'],function(){
    Route::group(['prefix'=>'admin'],
        function($router){
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::patch('/edit/{id}', [AuthController::class, 'update']);

        //Delete the category
        Route::delete('/delete-category/{category}', [CategoryController::class, 'delete']);
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
