<?php

namespace DavideCasiraghi\ResponsiveGallery\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    //protected $table = 'gallery_images';

    protected $fillable = [
        'file_name', 'description', 'alt', 'video_link',
    ];

    /* public $guarded = [];

     */
}
