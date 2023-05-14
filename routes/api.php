<?php

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

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/getRole', App\Http\Controllers\GetRole::class);

    Route::get('/getCategories', App\Http\Controllers\Category\GetCategories::class);
    Route::post('/changeComission', App\Http\Controllers\Category\ChangeComission::class);

    Route::get('/getSellerProducts', App\Http\Controllers\Product\Get\getSellerProducts::class);
    Route::get('/getBoughtProducts', App\Http\Controllers\Product\Get\GetBoughtProducts::class);
    Route::post('/getProducts', [App\Http\Controllers\Product\Get\GetProducts::class, 'store']);
    Route::post('/getProduct', App\Http\Controllers\Product\Get\GetProduct::class);
    Route::post('/readProduct', App\Http\Controllers\Product\ReadProduct::class);
    Route::post('/addProduct', App\Http\Controllers\Product\AddProduct::class);
    Route::post('/editProduct', App\Http\Controllers\Product\EditProduct::class);
    Route::post('/deleteProduct', App\Http\Controllers\Product\DeleteProduct::class);
    Route::post('/buyProduct', App\Http\Controllers\Product\BuyProduct::class);

    Route::post('/addCharacteristics', App\Http\Controllers\Characteristic\AddCharacteristics::class);
    Route::post('/getCharacteristics', App\Http\Controllers\Characteristic\GetCharacteristics::class);
    Route::post('/deleteCharacteristics', App\Http\Controllers\Characteristic\DeleteCharacteristics::class);

    Route::post('/addReview', App\Http\Controllers\Review\AddReview::class);
    Route::post('/getReviews', App\Http\Controllers\Review\GetReviews::class);
    Route::post('/deleteReview', App\Http\Controllers\Review\DeleteReview::class);

    Route::post('/getUser', App\Http\Controllers\User\GetUser::class);

    Route::post('/banUser', App\Http\Controllers\User\BanUser::class);
});
