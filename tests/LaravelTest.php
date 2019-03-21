<?php

namespace DavideCasiraghi\ResponsiveGallery\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Artisan;
use DavideCasiraghi\ResponsiveGallery\Models\GalleryImage;
use DavideCasiraghi\ResponsiveGallery\Facades\ResponsiveGallery;
use DavideCasiraghi\ResponsiveGallery\ResponsiveGalleryServiceProvider;

class LaravelTest extends TestCase
{

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadLaravelMigrations(['--database' => 'testbench']);
    }

    protected function getPackageProviders($app)
    {
        return [
            ResponsiveGalleryServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ResponsiveGallery' => ResponsiveGallery::class, // facade called ResponsiveQuote and the name of the facade class
        ];
    }

    /** @test */
    public function it_runs_the_migrations()
    {
        GalleryImage::insert([
            'file_name' => 'DSC_9470.jpg',
            'description' => 'Photo description',
            'alt' => 'Photo alt text',
            'video_link' => 'https://www.youtube.com/fsda234',
        ]);

        $image = GalleryImage::where('file_name', '=', 'DSC_9470.jpg')->first();

        $this->assertEquals('DSC_9470.jpg', $image->file_name);
    }

    /** @test */
    public function the_route_show_can_be_accessed()
    {
        GalleryImage::insert([
             'file_name' => 'DSC_9470.jpg',
             'description' => 'Photo description',
             'alt' => 'Photo alt text',
             'video_link' => 'https://www.youtube.com/fsda234',
         ]);
        
        $this->get("responsive-gallery/1")
            ->assertViewIs('laravel-responsive-gallery::show')
            ->assertViewHas('galleryImage')
            ->assertStatus(200);
    }
    
    /** @test */
    public function the_route_edit_can_be_accessed()
    {        
        GalleryImage::insert([
             'file_name' => 'DSC_9470.jpg',
             'description' => 'Photo description',
             'alt' => 'Photo alt text',
             'video_link' => 'https://www.youtube.com/fsda234',
         ]);
        
        $this->get("responsive-gallery/1/edit")
            ->assertViewIs('laravel-responsive-gallery::edit')
            //->assertViewHas('galleryImage')
            ->assertStatus(200);
    }
}
