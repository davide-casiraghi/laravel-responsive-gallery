<?php

namespace DavideCasiraghi\ResponsiveGallery\Tests;

use DavideCasiraghi\ResponsiveGallery\GalleryFactory;

use PHPUnit\Framework\TestCase; 

class GalleryFactoryTest extends TestCase
{
    /** @test */
    public function it_returns_file_extension()
    {
        $fileName = "testImage.jpg";
        
        $extension = GalleryFactory::get_file_extension($fileName);
        $this->assertEquals($extension, "jpg");
    }
    
    /** @test */
    public function it_returns_two_gallery_occurrences()
    {
        $text = "Lorem ipsum {# gallery src=[holiday_images/london] width=[400] height=[300] #} sid amet {# gallery src=[holiday_images/paris] width=[400] height=[300] #}";
        $gallery = new GalleryFactory();
        $matches = $gallery->getGallerySnippetOccurrences($text);
        
        $this->assertContains("holiday_images/london", $matches[0]);
    }
    
    /** @test */
    public function it_gets_gallery_parameters()
    {
        $single_gallery_matches = [
            0 => "{# gallery src=[holiday_images/london] width=[400] height=[300] #}",
            1 => "src",
            2 => "holiday_images/london",
            3 => "width",
            4 => "400",
            5 => "height",
            6 => "300",
        ];
  
        $gallery = new GalleryFactory();
        $parameters = $gallery->getGalleryParameters($single_gallery_matches);
        //var_dump($parameters['images_dir']);
        
        $this->assertSame("/images/holiday_images/london/", $parameters['images_dir']);
        
    }
    
    /** @test */
    public function it_read_dir_and_get_images_file_names()
    {
        $gallery = new GalleryFactory();
        $images_dir = __DIR__."/test_images";
        $imageNamesArray = $gallery->getImageFiles($images_dir);
        
        $this->assertContains("test_image_1.jpg", $imageNamesArray);
    }
    
    /** @test */
    public function it_generates_a_single_thumb()
    {
        
        $filePath = __DIR__."/test_images/test_image_1.jpg";
        $thumbPath = __DIR__."/test_images/thumb/test_image_1.jpg";
        $thumbWidth = 300;
        $thumbHeight = 200;
        
        $thumbs_dir = __DIR__."/test_images/thumb/";
        
        $gallery = new GalleryFactory();
        
        $gallery->generate_single_thumb_file($filePath, $thumbPath, $thumbWidth, $thumbHeight);
        $imageThumbNamesArray = $gallery->getImageFiles($thumbs_dir);
        $this->assertContains("test_image_1.jpg", $imageThumbNamesArray);    
        
        $thumbWidth = 200;
        $thumbHeight = 300;
        
        $gallery->generate_single_thumb_file($filePath, $thumbPath, $thumbWidth, $thumbHeight);
        $imageThumbNamesArray = $gallery->getImageFiles($thumbs_dir);
        $this->assertContains("test_image_1.jpg", $imageThumbNamesArray);    
        
    }
    
    /** @test */
    public function it_generates_thumbs()
    {
        $images_dir = __DIR__."/test_images/";
        $thumbs_dir = __DIR__."/test_images/thumb/";
        $thumbs_size['width'] = 40;
        $thumbs_size['height'] = 40;
        $image_files = ['test_image_1.jpg'];
        
        $gallery = new GalleryFactory();
        $gallery->generateThumbs($images_dir, $thumbs_dir, $thumbs_size, $image_files);
        
        $imageThumbNamesArray = $gallery->getImageFiles($thumbs_dir);
            
        $this->assertContains("test_image_1.jpg", $imageThumbNamesArray);
    }
    
    /** @test */
    public function it_creates_images_array()
    {
        $image_files = ['test_image_1.jpg'];
        $image_data = null;
        $gallery_url = __DIR__."/test_images/";
        
        $gallery = new GalleryFactory();
        $images = $gallery->createImagesArray($image_files, $image_data, $gallery_url);
        
        $this->assertStringContainsString('test_image_1.jpg',$images[0]['file_path']);
    }
    
    /** @test */
    public function it_prepare_gallery_html()
    {
        $images = array();
        $images[0] = [
            'file_path' => __DIR__."/test_images/test_image_1.jpg",
            'thumb_path' => __DIR__."/test_images/thumb/test_image_1.jpg",
            'description' => NULL,
            'video_link' => NULL,
        ];
        
        $gallery = new GalleryFactory();
        $galleryHtml = $gallery->prepareGallery($images);
        //var_dump($galleryHtml);
        $this->assertStringContainsString(
            "<div class='gallery'><div class='item animated'><a href='".$images[0]['file_path']."' data-fancybox='images' data-caption=''><img src='".$images[0]['thumb_path']."' /></a></div></div>",
            $galleryHtml);
    }
    
}
