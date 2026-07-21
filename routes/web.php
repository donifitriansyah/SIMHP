<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

require __DIR__.'/dashboard.php';
require __DIR__.'/master.php';
require __DIR__.'/lhp.php';
require __DIR__.'/laporan.php';
require __DIR__.'/auth.php';
