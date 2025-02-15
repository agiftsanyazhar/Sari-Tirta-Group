<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login.index')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.store')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
