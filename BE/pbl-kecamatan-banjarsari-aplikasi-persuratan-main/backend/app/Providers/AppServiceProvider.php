<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SuratMasuk;
use App\Observers\SuratMasukObserver;


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
        SuratMasuk::observe(SuratMasukObserver::class);
    }
}
