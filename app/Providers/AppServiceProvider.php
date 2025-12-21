<?php

namespace App\Providers;

use App\Models\AppelOffre;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Configuration du route model binding pour appels_offres
        Route::bind('appels_offre', function ($value) {
            return AppelOffre::findOrFail($value);
        });
    }
}
