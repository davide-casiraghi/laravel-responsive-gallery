<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryImagesTable extends Migration
{
    public function up()
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->unique();
            $table->text('description');
            $table->string('alt');
            $table->string('video_link');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gallery_images');
    }
}