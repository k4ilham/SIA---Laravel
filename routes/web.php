<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user/hapus/{id}', [UserController::class, 'destroy']);
Route::resource('/user', UserController::class);
