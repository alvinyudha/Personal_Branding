<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', [ProductsController::class, 'index']);
Route::resource('products', ProductsController::class);
Route::resource('categories', CategoriesController::class);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');