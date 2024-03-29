<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user/hapus/{id}', [UserController::class, 'destroy']);
Route::resource('/user', UserController::class);

Route::get('/barang/hapus/{id}', [BarangController::class, 'destroy']);
Route::resource('/barang', BarangController::class);
