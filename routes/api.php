<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/addItems',action: [ItemsController::class,'addItems'])->middleware('auth:api');
Route::get('/getItemByCategory',action: [ItemsController::class,'getItemByCategory']);
Route::get('/getMainCategory',action: [ItemsController::class,'getMainCategory']);
Route::get('/getItemById/{item_id}',action: [ItemsController::class,'getItemById']);

Route::post('/addToCart',action: [CartController::class,'addToCart'])->middleware('auth:api');
Route::get('/viewUserCart',action: [CartController::class,'viewUserCart'])->middleware('auth:api');
Route::delete('/removeItemFromCart',action: [CartController::class,'removeItemFromCart'])->middleware('auth:api');

Route::post('/addCard',action: [DeliveryController::class,'addCard'])->middleware('auth:api');
Route::post('/addDeliveryAddress',action: [DeliveryController::class,'addDeliveryAddress'])->middleware('auth:api');

