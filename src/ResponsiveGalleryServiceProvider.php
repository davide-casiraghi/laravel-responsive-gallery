<?php

namespace DavideCasiraghi\ResponsiveGallery;

use Illuminate\Support\ServiceProvider;

class ResponsiveGalleryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/assets/sass' => resource_path('sass/vendor/laravel-responsive-gallery/'),
        ], 'sass');
        $this->publishes([
            __DIR__.'/../resources/assets/js' => resource_path('js/vendor/laravel-responsive-gallery/'),
        ], 'js');
        
        $this->publishes([
            __DIR__ . '/../config/responsive-gallery.php' => base_path('config/responsive-gallery.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/responsive-gallery.php', 'responsive-gallery');
    }
}
