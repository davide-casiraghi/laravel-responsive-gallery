<?php

namespace DavideCasiraghi\ResponsiveGallery\Tests;

use Orchestra\Testbench\TestCase;
use DavideCasiraghi\ResponsiveGallery\Facades\ResponsiveGallery;
use DavideCasiraghi\ResponsiveGallery\ResponsiveGalleryServiceProvider;


class LaravelTest extends TestCase
{
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
    /*public function the_console_command_returns_a_quote()
    {
        $this->withoutMockingConsoleOutput();
        
        PhpResponsiveQuote::shouldReceive('getRandomQuote')
            ->once()
            ->andReturn('some joke');
        
        $this->artisan('php-responsive-quote');
        $output = Artisan::output();
        $this->assertSame('some joke'.PHP_EOL,$output);
    }*/
    
    /* @test */      
    public function the_route_can_be_accessed()
    {

        /*ResponsiveGallery::shouldReceive('getRandomQuote')
            ->once()
            ->andReturn('some joke');*/
        //dd($this->get('responsive-gallery'));
        $aa = $this->get('responsive-gallery')
            // ->assertViewIs('responsive-gallery::index')
            // ->assertViewHas('joke')
             //->assertViewHas('joke','some joke')
             ->assertStatus(500);
            
             
    }
}
