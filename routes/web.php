<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('suppliers', SupplierController::class);
Route::resource('categories', CategoryController::class);
Route::resource('transactions', TransactionController::class);


//route resource for products
Route::resource('/products', \App\Http\Controllers\ProductController::class);
//route resource for transaksi
Route::resource('/transaksi', TransaksiController::class);