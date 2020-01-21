<?php

namespace DavideCasiraghi\ResponsiveGallery\Tests;

use DavideCasiraghi\ResponsiveGallery\Models\GalleryImage;
use DavideCasiraghi\ResponsiveGallery\ResponsiveGalleryFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\TestCase;

//use DavideCasiraghi\ResponsiveGallery\Tests\Models\GalleryImage;

class ResponsiveGalleryFactoryTest extends TestCase
{
    /**
     * Create the tables this model needs for testing.
     */
    public static function setUpBeforeClass(): void
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
    }

    /**
     * Setup the test environment.
     */
    /*protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate', ['--database' => 'testing']);
    }*/

    /** @test */
    public function it_returns_file_extension()
    {
        $fileName = 'testImage.jpg';

        $extension = ResponsiveGalleryFactory::get_file_extension($fileName);
        $this->assertEquals($extension, 'jpg');
    }

    /** @test */
    public function it_returns_two_gallery_occurrences()
    {
        $text = 'Lorem ipsum {# gallery src=[holiday_images/london] column_width=[400] gutter=[2] #} sid amet {# gallery src=[holiday_images/paris] column_width=[400] gutter=[2] #}';
        $gallery = new ResponsiveGalleryFactory();
        $matches = $gallery->getGallerySnippetOccurrences($text);

        $this->assertContains('holiday_images/london', $matches[0]);

        $matches = $gallery->getGallerySnippetOccurrences('');
        $this->assertSame(null, $matches);
    }

    /** @test */
    public function it_gets_gallery_parameters()
    {
        $single_gallery_matches = [
            0 => '{# gallery src=[holiday_images/london] column_width=[400] gutter=[2] #}',
            1 => 'src',
            2 => 'holiday_images/london',
            3 => 'column_width',
            4 => '400',
            5 => 'gutter',
            6 => '2',
        ];

        $gallery = new ResponsiveGalleryFactory();
        $publicPath = '/images';
        $parameters = $gallery->getGalleryParameters($single_gallery_matches, $publicPath);
        //var_dump($parameters['images_dir']);

        $this->assertSame('/images/holiday_images/london/', $parameters['images_dir']);
    }

    /** @test */
    public function it_read_dir_and_get_images_file_names()
    {
        $gallery = new ResponsiveGalleryFactory();
        $images_dir = __DIR__.'/test_images';
        $imageNamesArray = $gallery->getImageFiles($images_dir);

        $this->assertContains('test_image_1.jpg', $imageNamesArray);
    }

    /** @test */
    public function it_generates_a_single_thumb()
    {
        $filePath = __DIR__.'/test_images/test_image_1.jpg';
        $thumbPath = __DIR__.'/test_images/thumb/test_image_1.jpg';
        $thumbs_dir = __DIR__.'/test_images/thumb/';
        $thumbWidth = 300;
        $thumbHeight = 200;

        $gallery = new ResponsiveGalleryFactory();

        $gallery->generate_single_thumb_file($filePath, $thumbPath, $thumbWidth, $thumbHeight);
        $imageThumbNamesArray = $gallery->getImageFiles($thumbs_dir);
        $this->assertContains('test_image_1.jpg', $imageThumbNamesArray);

        $filePath = __DIR__.'/test_images/test_image_vertical.jpg';
        $thumbPath = __DIR__.'/test_images/thumb/test_image_vertical.jpg';

        $gallery->generate_single_thumb_file($filePath, $thumbPath, $thumbWidth, $thumbHeight);
        $imageThumbNamesArray = $gallery->getImageFiles($thumbs_dir);
        $this->assertContains('test_image_1.jpg', $imageThumbNamesArray);
    }

    /** @test */
    public function it_generates_thumbs()
    {
        $images_dir = __DIR__.'/test_images/';
        $thumbs_dir = __DIR__.'/test_images/thumb/';
        $thumbs_size['width'] = 40;
        $thumbs_size['height'] = 40;
        $image_files = ['test_image_1.jpg'];
        $gallery = new ResponsiveGalleryFactory();

        $gallery->generateThumbs($images_dir, $thumbs_dir, $thumbs_size, $image_files);
        $imageThumbNamesArray = $gallery->getImageFiles($thumbs_dir);
        $this->assertContains('test_image_1.jpg', $imageThumbNamesArray);

        // Delete thumb dir before second test
        if (is_dir($thumbs_dir)) {
            array_map('unlink', glob("$thumbs_dir/*.*"));
            rmdir($thumbs_dir);
        }

        $gallery->generateThumbs($images_dir, $thumbs_dir, $thumbs_size, $image_files);
        $imageThumbNamesArray = $gallery->getImageFiles($thumbs_dir);
        $this->assertContains('test_image_1.jpg', $imageThumbNamesArray);
    }

    /** @test */
    public function it_creates_images_array()
    {
        $image_files = ['test_image_1.jpg'];
        $gallery_url = __DIR__.'/test_images/';

        $dbImageDatas = [
            'test_image_1.jpg' => new GalleryImage(),
            'IMG_1980.jpg' => new GalleryImage(),
        ];

        $gallery = new ResponsiveGalleryFactory();
        $images = $gallery->createImagesArray($image_files, $gallery_url, $dbImageDatas);

        $this->assertStringContainsString('test_image_1.jpg', $images[0]['file_path']);
    }

    /** @test */
    public function it_prepare_gallery_html()
    {
        $images = [];
        $images[0] = [
            'file_path' => __DIR__.'/test_images/test_image_1.jpg',
            'thumb_path' => __DIR__.'/test_images/thumb/test_image_1.jpg',
            'description' => null,
            'video_link' => null,
            'alt' => 'alt text',
        ];

        $parameters = [
            'token' => '{# gallery src=[holiday_images/london] column_width=[250] gutter=[20] #}',
            'column_width' => '250',
            'gutter' => '20',
            'images_dir' => 'public/storage/holiday_images/london/',
            'thumbs_dir' => 'public/storage/holiday_images/london/thumb/',
            'thumbs_size' => ['width' => 200, 'height' => 150],
        ];

        $gallery = new ResponsiveGalleryFactory();
        $galleryHtml = $gallery->prepareGallery($images, $parameters);
        //var_dump($parameters);
        $this->assertStringContainsString(
            "<div class='responsiveGallery bricklayer' id='my-bricklayer' data-column-width='".$parameters['column_width']."' data-gutter='".$parameters['gutter']."'><div class='box animated'><a href='".$images[0]['file_path']."' data-fancybox='images' data-caption=''><img src='".$images[0]['thumb_path']."' alt='".$images[0]['alt']."'/></a></div></div>",
            $galleryHtml);
    }

    /** @test */
    public function it_gets_photos_from_db()
    {
        $gallery = new ResponsiveGalleryFactory();
        $dbImageDatas = $gallery->getPhotoDatasFromDb();
        $this->assertStringContainsString($dbImageDatas['DSC_9470.jpg']->description, 'Photo description');
    }

    /** @test */
    public function it_gets_gallery()
    {
        $postBody = 'Lorem ipsum {# gallery src=[holiday_images] column_width=[400] gutter=[2] #} sid amet {# gallery src=[holiday_images/paris] column_width=[400] gutter=[2] #}';
        $publicPath = __DIR__.'/test_images';

        $gallery = new ResponsiveGalleryFactory();
        $postBodyWithGallery = $gallery->getGallery($postBody, $publicPath);

        $this->assertStringContainsString('Image directory not found', $postBodyWithGallery);
    }
}
