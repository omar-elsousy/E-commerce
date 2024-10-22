<?php

use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('ApiAuth')->group(function(){
    Route::controller(ApiProductController::class)->group(function(){
        Route::get('/products','getAll');
        Route::get('/product/show/{id}','show');
        Route::post('/product/store','store');
        Route::post('/product/update/{id}','update');
        Route::get('/product/delete/{id}','delete');
    });
});

Route::post('/user/register',[ApiUserController::class,'register']);
Route::post('/user/login',[ApiUserController::class,'login']);
Route::post('/user/logout',[ApiUserController::class,'logout']);
