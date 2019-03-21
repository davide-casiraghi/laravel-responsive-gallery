<?php

namespace DavideCasiraghi\ResponsiveGallery;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use DavideCasiraghi\ResponsiveGallery\Http\Controllers\ResponsiveGalleryController;

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
            __DIR__.'/../config/responsive-gallery.php' => base_path('config/responsive-gallery.php'),
        ], 'config');

        if (! class_exists('CreateGalleryImagesTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_gallery_images_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_gallery_images_table.php'),
            ], 'migrations');
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-responsive-gallery');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-responsive-gallery/'),
        ]);
        
        
        Route::group(['middleware' => 'web'], function () {
            //Route::get('responsive-gallery', ResponsiveGalleryController::class);
            Route::resource('responsive-gallery', ResponsiveGalleryController::class);
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/responsive-gallery.php', 'responsive-gallery');

        $this->app->bind('gallery-index', function () {
            return new ResponsiveGalleryFactory();
        });
    }
}
