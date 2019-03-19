<?php

namespace DavideCasiraghi\ResponsiveGallery;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    //protected $table = 'gallery_images';


    protected $fillable = [
        'file_name', 'description', 'alt', 'video_link'
    ];
    
   

   /* public $guarded = [];

    public $casts = [
        'serialized_event' => 'array',
    ];

    public static function createForEvent(ShouldBeStored $event): self
    {
        return static::create([
            'event_class' => get_class($event),
            'serialized_event' => serialize(clone $event),
        ]);
    }

    public function getEventAttribute(): ShouldBeStored
    {
        return unserialize($this->serialized_event);
    }*/
}
