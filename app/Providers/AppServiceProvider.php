<?php

namespace App\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

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
        FilamentAsset::register([
            // Register your custom CSS
            Css::make('nilai-styles', resource_path('css/nilai.css')),
            // Register your custom JS
            Js::make('nilai-scripts', resource_path('js/nilai.js')),
        ]);
    }
}
