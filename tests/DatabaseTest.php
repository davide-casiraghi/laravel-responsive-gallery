<?php

namespace DavideCasiraghi\ResponsiveGallery\Tests;

use Illuminate\Support\Facades\DB;
//use DavideCasiraghi\ResponsiveGallery\Tests\MyDBFacade;

use Mockery\Adapter\Phpunit\MockeryTestCase;

/*interface DB {
    function find($id): array;
    function get(): array;
}*/

class DatabaseTest extends MockeryTestCase
{
    /** @test */
    public function it_gets_photo_data_from_db()
    {
        //$table_name = config('random-quote.table_name');
        $tableName = 'photos';

        $returnValue = new MyDBFacade();
        $returnValue->file_name = 'DSC_9470.jpg';
        $returnValue->description = 'Photo description';
        $returnValue->alt_text = 'Photo alt text';
        $returnValue->video_link = 'https://www.youtube.com/fsda234';

        /*$mock = \Mockery::mock('DB');
        $mock->shouldReceive('get')
            ->with()
            ->once()
            ->andReturn($returnValue);

        $book = $mock->get();
        var_dump($book);*/

        $mock = \Mockery::mock('MyDBFacade');
        $mock->shouldReceive('table')
            ->with($tableName)
            ->once()
            ->andReturn($returnValue);

        $photos = $mock->table($tableName)->get();
        var_dump($photos);

        /*$book2 = $mock->table($tableName)->get();
        var_dump($book2);*/
    }

    /* @test */
    /*public function it_gets_photo_data_from_db()
    {
        DB::shouldReceive("raw")
           ->set('query', 'query test')
           ->andReturn(true);
    }
    */
}
