<?php
namespace Orchestra\Testbench\Tests\Databases;
use Orchestra\Testbench\TestCase;

use DavideCasiraghi\ResponsiveGallery\ResponsiveGalleryServiceProvider;

class MigrateDatabaseTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
    }
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
    }
    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            //\Orchestra\Testbench\Tests\Stubs\Providers\ServiceProvider::class,
            ResponsiveGalleryServiceProvider::class,
        ];
    }
    /**
     * Get package aliases.  In a normal app environment these would be added to
     * the 'aliases' array in the config/app.php file.  If your package exposes an
     * aliased facade, you should add the alias here, along with aliases for
     * facades upon which your package depends, e.g. Cartalyst/Sentry.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
            //'YourPackage' => 'YourProject\YourPackage\Facades\YourPackage',
        ];
    }
    /** @test */
    /*public function it_runs_the_migrations()
    {
        $galleryImages = \DB::table('gallery_images')->where('id', '=', 1)->first();
        $this->assertEquals('aaa', $galleryImages->email);
        
        $columns = \Schema::getColumnListing('gallery_images');
        $this->assertEquals([
            'file_name',
            'description',
            'alt',
            'video_link',
            'created_at',
            'updated_at',
        ], $columns);
    }*/
}
