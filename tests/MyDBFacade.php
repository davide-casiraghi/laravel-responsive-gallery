<?php

namespace DavideCasiraghi\ResponsiveGallery\Tests;

use Illuminate\Support\Facades\DB;

class MyDBFacade extends DB
{
    public function get(){
        return "ciao";
    }
}
