<?php

namespace TFHInc\ArtisanFormat;

use Illuminate\Support\ServiceProvider;

class ArtisanFormatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Provide the Config File for Publishing
        $this->publishes([
            __DIR__ . '/../config/artisan-format.php' => config_path('artisan-format.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Provide Config if not published
        $this->mergeConfigFrom(__DIR__.'/../config/artisan-format.php', 'artisan-format');
    }
}
