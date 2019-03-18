<?php

namespace DavideCasiraghi\ResponsiveGallery;

use Illuminate\Support\Facades\DB;

class ResponsiveGalleryFactory
{
    /************************************************************************/

    /**
     *  Returns the plugin parameters.
     *  @param array $matches       result from the regular expression on the string from the article
     *  @return array $ret          the array containing the parameters
     **/
    public static function getGalleryParameters($matches, $publicPath)
    {
        $ret = [];

        // Get Paths
        $sitePath = '/';
        $siteUrl = $publicPath;

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];
        $subDir = $matches[2];
        $ret['column_width'] = $matches[4];
        $ret['gutter'] = $matches[6];

        // Directories
        $ret['images_dir'] = $publicPath.'/'.$subDir.'/';
        $ret['thumbs_dir'] = $publicPath.'/'.$subDir.'/thumb/';

        // Thumbnails size
        $ret['thumbs_size']['width'] = 300;
        $ret['thumbs_size']['height'] = 300;

        // URL variables
        $ret['gallery_url'] = $subDir.'/';
        $ret['thumb_url'] = $subDir.'/thumbs/';

        return $ret;
    }

    /************************************************************************/

    /**
     *  Generate a single thumbnail file from an image.
     *  @param array $src               path of the original image
     *  @param array $dest              path of the generated thumbnail
     *  @param array $desired_width     width of the thumbnail
     *  @return create a file
     **/
    public function generate_single_thumb_file($src, $dest, $desired_width, $desired_height)
    {
        // Read the source image
        $source_image = imagecreatefromjpeg($src);

        // Get width and height of the original image
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        // Horizontal image
        if ($width > $height) {
            $desired_width = 400;
            $desired_height = floor($height * ($desired_width / $width));
        }
        // Vertical image
        else {
            $desired_height = 500;
            $desired_width = floor($width * ($desired_height / $height));
        }

        // Create a new, "virtual" image
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        // Copy source image at a resized size
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        //Create the physical thumbnail image to its destination
        imagejpeg($virtual_image, $dest);
    }

    /************************************************************************/

    /**
     *  Generate all the thumbnails of the gallery.
     *  @param string $images_dir        images dir on the server
     *  @param string $thumbs_dir        thumb dir on the server
     *  @param string $$thumbs_size
     *  @param array $image_files
     *  @return generate thumbnail files
     **/
    public function generateThumbs($images_dir, $thumbs_dir, $thumbs_size, $image_files)
    {

        // Thumbnails size
        $thumbs_width = $thumbs_size['width'];
        $thumbs_height = $thumbs_size['height'];

        //  Create thumbs dir
        if (! is_dir($thumbs_dir)) {
            mkdir($thumbs_dir);
        }

        // Generate missing thumbs
        if (count($image_files)) {
            $index = 0;
            foreach ($image_files as $index=>$file) {
                $index++;
                $thumbnail_image = $thumbs_dir.$file;
                if (! file_exists($thumbnail_image)) {
                    $extension = $this->get_file_extension($thumbnail_image);
                    if ($extension) {
                        //echo $images_dir." ".$file." ".$thumbnail_image." ".$thumbs_width;
                        $this->generate_single_thumb_file($images_dir.$file, $thumbnail_image, $thumbs_width, $thumbs_height);
                    }
                }
            }
        }
    }

    /************************************************************************/

    /**
     *  Create images array.
     *  @param array $image_files           array with all the image names
     *  @param $image_data
     *  @param $gallery_url
     *  @return $ret    array with the images datas
     **/
    public function createImagesArray($image_files, $image_data, $gallery_url)
    {
        sort($image_files);  // Order by image name

        $ret = [];

        foreach ($image_files as $k => $image_file) {
            $ret[$k]['file_path'] = $gallery_url.$image_file;
            $ret[$k]['thumb_path'] = $gallery_url.'thumb/'.$image_file;
            $ret[$k]['description'] = $image_data[$image_file]['description'];
            $ret[$k]['video_link'] = $image_data[$image_file]['video'];
        }

        return $ret;
    }

    /************************************************************************/

    /**
     *  Get images file names array.
     *  @param $images_dir           the images dir on the server
     *  @return array $ret           array containing all the images file names
     **/
    public function getImageFiles($images_dir)
    {
        $ret = $this->get_files($images_dir);

        return $ret;
    }

    /************************************************************************/

    /**
     *  Prepare the gallery HTML.
     *  @param array $images                        Images array [file_path, short_desc, long_desc]
     *  @param array $bootstrapDeviceImageWidth     array that contain the sizes of the images
     *                                              for the four kind of bootrap devices classes ()
     *                                              xs (phones), sm (tablets), md (desktops), and lg (larger desktops)
     *  @param ****array $desired_width     width of the thumbnail
     *  @return string $ret             the HTML to print on screen
     **/
    public function prepareGallery($images, $parameters)
    {
        //dd($parameters);
        // Animate item on hover
        $itemClass = 'animated';

        // The gallery HTML
        $ret = "<div class='responsiveGallery bricklayer' id='my-bricklayer' data-column-width='".$parameters['column_width']."' data-gutter='".$parameters['gutter']."'>";

        foreach ($images as $k => $image) {

            // Get item link
            $imageLink = ($image['video_link'] == null) ? $image['file_path'] : $image['video_link'];
            $videoPlayIcon = ($image['video_link'] == null) ? '' : "<i class='far fa-play-circle'></i>";

            $ret .= "<div class='box ".$itemClass."'>";
            $ret .= "<a href='".$imageLink."' data-fancybox='images' data-caption='".$image['description']."'>";
            $ret .= "<img src='".$image['thumb_path']."' />";
            $ret .= $videoPlayIcon;
            $ret .= '</a>';
            $ret .= '</div>';
        }

        $ret .= '</div>';

        return $ret;
    }

    /************************************************************************/

    /**
     *  Returns files from dir.
     *  @param string $images_dir                 The images directory
     *  @param array $exts     the file types (actually doesn't work the thumb with png, it's to study why)
     *  @return array $files             the files array
     **/
    public function get_files($images_dir, $exts = ['jpg'])
    {
        $files = [];

        if ($handle = opendir($images_dir)) {
            while (false !== ($file = readdir($handle))) {
                $extension = strtolower($this->get_file_extension($file));
                if ($extension && in_array($extension, $exts)) {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }

        return $files;
    }

    /************************************************************************/

    /**
     *  Returns a file's extension.
     *  @param string $file_name        the file name
     *  @return string                  the extension
     **/
    public static function get_file_extension($file_name)
    {
        return substr(strrchr($file_name, '.'), 1);
    }

    /************************************************************************/

    /**
     *  Find the gallery snippet occurances in the text.
     *  @param array $text        the text where to find the gallery snippets
     *  @return array $ret        the matches
     **/
    public function getGallerySnippetOccurrences($text)
    {
        $re = '/{\#
                \h+gallery
                \h+(src|column_width|gutter)=\[([^]]*)]
                \h+((?1))=\[([^]]*)]
                \h+((?1))=\[([^]]*)]
                \h*\#}/x';

        if (preg_match_all($re, $text, $matches, PREG_SET_ORDER, 0)) {
            return $matches;
        } else {
            return;
        }
    }
    
    /************************************************************************/
    /**
     *  Retrieve the datas from the package config file (published and edited by the user)
     *  @param none
     *  @return array $ret - the config parapeters
     **/
    public function getPhotoDatas($photoFileName)
    {
        
        $table_name = config('responsive-gallery.table_name');
        $field_file_name = config('responsive-gallery.field_filename');
        $field_description = config('responsive-gallery.field_description');
        $field_alt_text = config('responsive-gallery.field_alt_text');
        $field_video_link = config('responsive-gallery.field_video_link');

        $ret = DB::table($tableName)->keyBy($field_file_name);
        
        dd()
        /*$photoTableDatas = Cache::get('photo_datas', function () {
            return  DB::table($tableName)->get();
        });*/
        /*
        $singlePhotoDatas->contains($field_file_name, $photoFileName);
        
        $ret['file_name'] = $singlePhotoDatas->contains($field_file_name, $photoFileName);
        $ret['description'] = null;
        $ret['alt_text'] = null;
        $ret['video_link'] = null;*/
        
                        

        return $ret;
    }

    /************************************************************************/
    /**
     *  Return the post body with the gallery HTML instead of the found snippet.
     *  @param array $file_name        the file name
     *  @return array $ret             the extension
     **/
    public function getGallery($postBody, $publicPath)
    {
        $matches = $this->getGallerySnippetOccurrences($postBody);

        foreach ($matches as $key => $single_gallery_matches) {
            $parameters = $this->getGalleryParameters($single_gallery_matches, $publicPath);
            //dd($parameters);
            if (is_dir($parameters['images_dir'])) {
                // Get images file name array
                $image_files = $this->getImageFiles($parameters['images_dir']);
                //sort($image_files,SORT_STRING);

                if (! empty($image_files)) {
                    // Get images data from excel
                    //$image_data = $this->getImgDataFromExcel($parameters['images_dir']);
                    $image_data = null;
                    // Generate thumbnails files
                    $this->generateThumbs($parameters['images_dir'], $parameters['thumbs_dir'], $parameters['thumbs_size'], $image_files);

                    // Create Images array [file_path, short_desc, long_desc]
                    $images = $this->createImagesArray($image_files, $image_data, $parameters['gallery_url']);

                    // Prepare Gallery HTML
                    $galleryHtml = $this->prepareGallery($images, $parameters);
                } else {
                    $galleryHtml = "<div class='alert alert-warning' role='alert'>The directory specified exist but it doesn't contain images</div>";
                }
            } else {
                $galleryHtml = "<div class='alert alert-warning' role='alert'>Image directory not found<br />".$parameters['images_dir'].'</div>';
            }

            // Replace the TOKEN found in the article with the generatd gallery HTML
            $postBody = str_replace($parameters['token'], $galleryHtml, $postBody);
        }

        return $postBody;
    }
}
