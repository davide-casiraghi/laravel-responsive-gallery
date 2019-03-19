<?php

namespace DavideCasiraghi\ResponsiveGallery\Facades;

use Illuminate\Support\Facades\Facade;

class ResponsiveGallery extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'gallery-index';
    }
}
