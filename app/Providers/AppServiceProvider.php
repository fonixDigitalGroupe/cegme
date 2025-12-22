<?php

namespace App\Providers;

use App\Models\AppelOffre;
use App\Models\TypeMarche;
use App\Models\PoleActivite;
use App\Models\MotCle;
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
        
        // Route model binding pour les nouvelles ressources
        Route::bind('type_marche', function ($value) {
            return TypeMarche::findOrFail($value);
        });
        
        Route::bind('pole_activite', function ($value) {
            return PoleActivite::findOrFail($value);
        });
        
        Route::bind('mots_cle', function ($value) {
            return MotCle::findOrFail($value);
        });
        
        // Alias pour compatibilité
        Route::bind('motsCle', function ($value) {
            return MotCle::findOrFail($value);
        });
    }
}
