<?php

namespace Orchestra\Testbench\Tests\Databases;
//namespace DavideCasiraghi\ResponsiveGallery\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;
use DavideCasiraghi\ResponsiveGallery\Models\GalleryImage;
use DavideCasiraghi\ResponsiveGallery\Facades\ResponsiveGallery;
use DavideCasiraghi\ResponsiveGallery\ResponsiveGalleryServiceProvider;


class LaravelTest extends TestCase
{
    /**
     * Create the tables this model needs for testing.
     */
    /*public static function setUpBeforeClass() : void
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
    */
    
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
        //Artisan::call('migrate', ['--database' => 'testing']);
        // To run migrations that are only used for testing purposes
        //$this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        
        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        //$this->artisan('migrate', ['--database' => 'testbench'])->run();
        
        /*$this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--path' => realpath(__DIR__ . '/database/migrations'),
        ]);*/
        
        
        
        //$tables = \DB::select('SHOW TABLES');
        //dd($tables);
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
    /*public function it_runs_the_migrations()
    {        
       GalleryImage::insert([
            'file_name' => 'DSC_9470.jpg',
            'description' => 'Photo description',
            'alt_text' => 'Photo alt text',
            'video_link' => 'https://www.youtube.com/fsda234',
        ]);
        
        $image = GalleryImage::where('file_name', '=', 'DSC_9470.jpg')->first();
        
        $this->assertEquals('DSC_9470.jpg', $image->file_name);
        
        dd("sdfsd");
   }*/


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
        /*$body = 'Etiam aliquet orci tortor';
        $publicPath = '/aaaa/bbb/';

        ResponsiveGallery::shouldReceive('getGallery')
            ->once()
            ->with($body,$publicPath)
            ->andReturn('some joke');*/
        //->andReturn(true);

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
