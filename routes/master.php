<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IrbanController;
use App\Http\Controllers\AuditeeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PihakKetigaController;
use App\Http\Controllers\ProfilInspektoratController;
use App\Http\Controllers\EditRequestController;

Route::middleware(['auth','role:super_user,user_entry'])->group(function(){

    Route::resource('irban',IrbanController::class);

    Route::resource('auditee',AuditeeController::class);

    Route::resource('pegawai',PegawaiController::class);

    Route::resource('pihak-ketiga',PihakKetigaController::class);

});

Route::middleware(['auth','role:super_user'])->group(function(){

    Route::resource('users',UserController::class);

    Route::resource('profil-inspektorat',ProfilInspektoratController::class);

    Route::resource('edit-requests',EditRequestController::class);

    Route::put(
        '/edit-requests/{editRequest}/approve',
        [EditRequestController::class,'approve']
    )->name('edit-requests.approve');

    Route::put(
        '/edit-requests/{editRequest}/reject',
        [EditRequestController::class,'reject']
    )->name('edit-requests.reject');

    Route::put(
        '/edit-requests/{editRequest}/complete',
        [EditRequestController::class,'complete']
    )->name('edit-requests.complete');

});
