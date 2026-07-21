<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MatriksTindakLanjutController;

Route::middleware(['auth','role:super_user'])->group(function(){

    Route::get('/laporan',
        [LaporanController::class,'index'])
        ->name('laporan.index');

    Route::get('/laporan-cetak',
        [LaporanController::class,'cetak'])
        ->name('laporan.cetak');

    Route::get('/laporan/irban',
        [LaporanController::class,'irban'])
        ->name('laporan.irban');

    Route::get('/laporan/irban/cetak',
        [LaporanController::class,'cetakIrban'])
        ->name('laporan.irban.cetak');

    Route::get('/laporan/semua-irban/cetak',
        [LaporanController::class,'cetakSemuaIrban'])
        ->name('laporan.semua-irban.cetak');

    Route::get('/laporan/pns-temuan',
        [LaporanController::class,'pnsTemuan'])
        ->name('laporan.pns.temuan');

    Route::get('/laporan/pns-temuan/cetak',
        [LaporanController::class,'cetakPnsTemuan'])
        ->name('laporan.pns.temuan.cetak');

    Route::get('/laporan/pihak-ketiga-temuan',
        [LaporanController::class,'pihakKetigaTemuan'])
        ->name('laporan.pihak.ketiga.temuan');

    Route::get('/laporan/pihak-ketiga-temuan/cetak',
        [LaporanController::class,'cetakPihakKetigaTemuan'])
        ->name('laporan.pihak.ketiga.temuan.cetak');

    Route::get('/matriks',
        [MatriksTindakLanjutController::class,'index'])
        ->name('matriks.index');

});
