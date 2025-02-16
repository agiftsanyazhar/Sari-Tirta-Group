<?php

use App\Http\Controllers\{AppointmentController};
use Illuminate\Support\Facades\Route;

Route::prefix('appointment')->name('appointment.')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('index');
    Route::post('/store', [AppointmentController::class, 'store'])->name('store');
    Route::post('/update', [AppointmentController::class, 'update'])->name('update');
    Route::get('/destroy/{id}', [AppointmentController::class, 'destroy'])->name('destroy');
});
