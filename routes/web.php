<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiPenjualanController;

use App\Http\Controllers\ProductCategoryController;

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\SupplierController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('suppliers', SupplierController::class);
Route::resource('transaksi', TransaksiPenjualanController::class);
Route::resource('/products', \App\Http\Controllers\ProductController::class);
Route::resource('categories', ProductCategoryController::class);
