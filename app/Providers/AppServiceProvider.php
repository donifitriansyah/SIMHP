<?php

namespace App\Providers;

use App\Models\Lhp;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

        View::composer(
            'layouts.backend',
            function ($view) {

                $view->with('jumlahLhp', [

                    'semua' => Lhp::count(),

                    'nihil' => Lhp::where(
                        'status_proses',
                        'nihil'
                    )->count(),

                    'belum_proses' => Lhp::where(
                        'status_proses',
                        'belum_diproses'
                    )->count(),

                    'dalam_proses' => Lhp::where(
                        'status_proses',
                        'dalam_proses'
                    )->count(),

                    'selesai' => Lhp::where(
                        'status_proses',
                        'selesai'
                    )->count(),

                ]);
            }
        );
    }
}
