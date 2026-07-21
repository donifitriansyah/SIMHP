<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index'])
        ->name('dashboard');

    Route::get('/dashboard/internal', [DashboardController::class,'index'])
        ->defaults('jenis','internal')
        ->name('dashboard.internal');

    Route::get('/dashboard/eksternal', [DashboardController::class,'index'])
        ->defaults('jenis','eksternal')
        ->name('dashboard.eksternal');

});
