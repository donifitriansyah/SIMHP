<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LhpController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TindakLanjutController;

Route::middleware('auth')->group(function(){

    Route::get('/pemeriksaan/internal',
        [LhpController::class,'index'])
        ->defaults('jenis','internal')
        ->name('pemeriksaan.internal');

    Route::get('/pemeriksaan/eksternal',
        [LhpController::class,'index'])
        ->defaults('jenis','eksternal')
        ->name('pemeriksaan.eksternal');

    Route::get('/lhp',[LhpController::class,'index'])
        ->name('lhp.index');

    Route::get('/lhp/{lhp}',[LhpController::class,'show'])
        ->name('lhp.show');

    Route::get('/lhp/{lhp}/cetak',[LhpController::class,'cetak'])
        ->name('lhp.cetak');

    Route::get('/auditee/{auditee}/pejabat',
        [LhpController::class,'getPejabat'])
        ->name('auditee.pejabat');

});

Route::middleware('auth')->group(function(){

    Route::prefix('laporan-hasil-pemeriksaan/{lhp}')
        ->group(function(){

        Route::get('temuan/create',
            [TemuanController::class,'create'])
            ->name('temuan.create');

        Route::post('temuan',
            [TemuanController::class,'store'])
            ->name('temuan.store');

    });

});

Route::middleware(['auth','role:super_user'])->group(function(){

    Route::post('/lhp/{lhp}/tetapkan-nihil',
        [LhpController::class,'tetapkanNihil'])
        ->name('lhp.tetapkan-nihil');

    Route::put('/lhp/{lhp}/selesai',
        [LhpController::class,'selesai'])
        ->name('lhp.selesai');

    Route::get('/lhp/filter/{status}',
        [LhpController::class,'filter'])
        ->name('lhp.filter');

    Route::get('/lhp-lengkap',
        [LhpController::class,'lengkap'])
        ->name('lhp.lengkap');

    Route::get('/lhp-belum-lengkap',
        [LhpController::class,'belumLengkap'])
        ->name('lhp.belum-lengkap');

});

