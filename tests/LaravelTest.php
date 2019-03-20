<?php

namespace DavideCasiraghi\ResponsiveGallery\Tests;

use Orchestra\Testbench\TestCase;
use DavideCasiraghi\ResponsiveGallery\Facades\ResponsiveGallery;
use DavideCasiraghi\ResponsiveGallery\ResponsiveGalleryServiceProvider;
use DavideCasiraghi\ResponsiveGallery\Models\GalleryImage;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Artisan;

class LaravelTest extends TestCase
{
    /**
     * Create the tables this model needs for testing.
     */
    public static function setUpBeforeClass() : void 
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        
        Capsule::schema()->create('gallery_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->unique();
            $table->text('description')->nullable();
            $table->string('alt')->nullable();
            $table->string('video_link')->nullable();
            $table->timestamps();
        });
        
        //Model::unguard();
        
        GalleryImage::create([
            'file_name' => 'DSC_9470.jpg',
            'description' => 'Photo description',
            'alt_text' => 'Photo alt text',
            'video_link' => 'https://www.youtube.com/fsda234',
        ]);
        
        //Artisan::call('migrate', ['--database' => ':memory:']);
        //$this->artisan('migrate', ['--database' => ':memory:'])->run();
    }
    
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate', ['--database' => 'testing']);
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
        //dd(GalleryImage::get());
        /*ResponsiveGallery::shouldReceive('getRandomQuote')
            ->once()
            ->andReturn('some joke');*/
        //dd($this->get('responsive-gallery'));
        $aa = $this->get('responsive-gallery')
            // ->assertViewIs('responsive-gallery::index')
            // ->assertViewHas('joke')
             //->assertViewHas('joke','some joke')
             ->assertStatus(500);
            //dd($aa);
             
    }
}
