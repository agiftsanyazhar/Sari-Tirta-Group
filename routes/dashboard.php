<?php

use App\Http\Controllers\{AppointmentController};
use Illuminate\Support\Facades\Route;

Route::prefix('appointment')->name('appointment.')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('index');
});
