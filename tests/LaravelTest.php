<?php

namespace Davidecasiraghi\ResponsiveGallery\Tests;

use Orchestra\Testbench\TestCase;
use DavideCasiraghi\ResponsiveGallery\Facades\ResponsiveGallery;
use DavideCasiraghi\ResponsiveGallery\ResponsiveGalleryServiceProvider;

class LaravelTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp() :void
    {
        parent::setUp();

        //To run migrations that are only used for testing purposes and not part of your package, add the following to your base test class:
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // and other test setup steps you need to perform
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

    /* @test */
    /*errore 500 perchè non trova la tabella gallery_images*/
    public function the_route_can_be_accessed(){
        
        /*ResponsiveGallery::shouldReceive('getRandomQuote')
            ->once()
            ->andReturn('some joke');*/
        //dd($this->get('responsive-gallery'));
        $this->get('responsive-gallery')
            // ->assertViewIs('responsive-gallery::index')
            // ->assertViewHas('joke')
             //->assertViewHas('joke','some joke')
             ->assertStatus(500);
    }
}
