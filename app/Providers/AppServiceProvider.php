<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema; // <--- BARIS INI DITAMBAHKAN


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
    public function boot(): void
    {
        // <--- BARIS INI DITAMBAHKAN UNTUK MEMPERBAIKI MASALAH PANJANG KUNCI
        Schema::defaultStringLength(191);
    }
}