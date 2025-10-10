<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('welcome');
});

//route resource for products
Route::resource('/products', \App\Http\Controllers\ProductController::class);
//route resource for transaksi
Route::resource('transaksi', \App\Http\Controllers\TransaksiController::class);
Route::get('/transactions', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/transactions/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
