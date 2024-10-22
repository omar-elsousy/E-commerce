<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/notAuth',function(){
    return 'You do not have permition to visit this page';
});
Route::get('/home',[HomeController::class,'index']);
Route::get('/lang/{lang}',[LangController::class,'index']);

Route::middleware('auth')->group(function(){
    Route::get('/allProducts',[UserProductController::class,'getAll']);
    Route::get('/showProduct/{id}',[UserProductController::class,'show']);
    Route::get('/search',[UserProductController::class,'search']);
    Route::post('/add_to_cart/{id}',[UserProductController::class,'add_to_cart']);
    Route::get('/my_cart',[UserProductController::class,'my_cart']);
    Route::post('/make_order',[UserProductController::class,'make_order']);
});


Route::middleware(['isAdmin','auth'])->group(function(){
    Route::controller(ProductController::class)->group(function(){
        Route::get('/products','getAll');
        Route::get('/product/create','create');
        Route::post('/product/store','store');
        Route::get('/product/edit/{id}','edit');
        Route::post('/product/update/{id}','update');
        Route::get('/product/delete/{id}','delete');
    });
});




