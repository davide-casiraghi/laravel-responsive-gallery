<?php

namespace DavideCasiraghi\ResponsiveGallery;

use DavideCasiraghi\ResponsiveGallery\Models\GalleryImage;

class ResponsiveGalleryFactory
{
    /************************************************************************/

    /**
     *  Returns the plugin parameters.
     *  @param array $matches       Result from the regular expression on the string from the article
     *  @param string $publicPath
     *  @return array $ret          The array containing the parameters
     **/
    public static function getGalleryParameters($matches, $publicPath)
    {
        $ret = [];

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
     *  @param array $desired_height    height of the thumbnail
     *  @return void
     **/
    public function generate_single_thumb_file($src, $dest, $desired_width, $desired_height) : void
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
     *  @param string $images_dir      Images dir on the server
     *  @param string $thumbs_dir      Thumb dir on the server
     *  @param string $thumbs_size
     *  @param array  $image_files
     *  @return void
     **/
    public function generateThumbs($images_dir, $thumbs_dir, $thumbs_size, $image_files) : void
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
                    $extension = self::get_file_extension($thumbnail_image);
                    if ($extension) {
                        $this->generate_single_thumb_file($images_dir.$file, $thumbnail_image, $thumbs_width, $thumbs_height);
                    }
                }
            }
        }
    }

    /************************************************************************/

    /**
     *  Create images array.
     *  @param array        $image_file_names  Array with all the image names
     *  @param string       $gallery_url
     *  @param GalleryImage $dbImageDatas
     *  @return array       $ret               Array with the images datas
     **/
    public function createImagesArray($image_file_names, $gallery_url, $dbImageDatas)
    {
        sort($image_file_names);  // Order by image name

        $ret = [];

        foreach ($image_file_names as $k => $image_file_name) {
            $ret[$k]['file_name'] = $image_file_name;
            $ret[$k]['file_path'] = $gallery_url.$image_file_name;
            $ret[$k]['thumb_path'] = $gallery_url.'thumb/'.$image_file_name;
            $ret[$k]['description'] = '';
            $ret[$k]['alt'] = '';
            $ret[$k]['video_link'] = null;

            if (! empty($dbImageDatas[$image_file_name])) {
                $ret[$k]['description'] = $dbImageDatas[$image_file_name]->description;
                $ret[$k]['alt'] = $dbImageDatas[$image_file_name]->alt;
                $ret[$k]['video_link'] = $dbImageDatas[$image_file_name]->video_link;
            }
        }

        return $ret;
    }

    /************************************************************************/

    /**
     *  Get images file names array.
     *  @param  string $images_dir   The images dir on the server
     *  @return array  $ret          All the images file names
     **/
    public function getImageFiles($images_dir)
    {
        $ret = $this->get_files($images_dir);

        return $ret;
    }

    /************************************************************************/

    /**
     *  Prepare the gallery HTML.
     *  @param array $images       Images array [file_path, short_desc, long_desc]
     *  @param array $parameters
     *  @return string $ret        The HTML to print on screen
     **/
    public function prepareGallery($images, $parameters)
    {
        // Animate image box on hover
        $itemClass = 'animated';

        // The gallery HTML
        $ret = "<div class='responsiveGallery bricklayer' id='my-bricklayer' data-column-width='".$parameters['column_width']."' data-gutter='".$parameters['gutter']."'>";
        foreach ($images as $k => $image) {
            // Get item link
            $imageLink = ($image['video_link'] == null) ? $image['file_path'] : $image['video_link'];
            $videoPlayIcon = ($image['video_link'] == null) ? '' : "<i class='far fa-play-circle'></i>";

            $ret .= "<div class='box ".$itemClass."'>";
            $ret .= "<a href='".$imageLink."' data-fancybox='images' data-caption='".$image['description']."'>";
            $ret .= "<img src='".$image['thumb_path']."' alt='".$image['alt']."'/>";
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
     *  @param string $images_dir  The images directory
     *  @param  array $exts        The file types (actually doesn't work the thumb with png, it's to study why)
     *  @return array $files       The files array
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
     *  @param  string  $file_name   The file name
     *  @return string  $ret         The extension without dot
     **/
    public static function get_file_extension($file_name)
    {
        $ret = substr(strrchr($file_name, '.'), 1);

        return $ret;
    }

    /************************************************************************/

    /**
     *  Find the gallery snippet occurances in the text.
     *  @param array $text     The text where to find the gallery snippets
     *  @return array $ret     The matches
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
     *  Retrieve the datas from the package config file (published and edited by the user).
     *  @return array $ret - the config parapeters
     **/
    public function getPhotoDatasFromDb()
    {
        $ret = GalleryImage::get()->keyBy('file_name');

        return $ret;
    }

    /************************************************************************/

    /**
     *  Return the post body with the gallery HTML instead of the found snippet.
     *  @param array  $postBody       The text name
     *  @param string $publicPath
     *  @return array $ret            $postBody with the HTML Galleries
     **/
    public function getGallery($postBody, $publicPath)
    {
        $matches = $this->getGallerySnippetOccurrences($postBody);

        foreach ($matches as $key => $single_gallery_matches) {
            $parameters = self::getGalleryParameters($single_gallery_matches, $publicPath);

            if (is_dir($parameters['images_dir'])) {
                // Get images file name array
                $image_files = $this->getImageFiles($parameters['images_dir']);

                if (! empty($image_files)) {
                    $this->generateThumbs($parameters['images_dir'], $parameters['thumbs_dir'], $parameters['thumbs_size'], $image_files);
                    $dbImageDatas = $this->getPhotoDatasFromDb();

                    // Create Images array [file_path, short_desc, long_desc]
                    $images = $this->createImagesArray($image_files, $parameters['gallery_url'], $dbImageDatas);

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
