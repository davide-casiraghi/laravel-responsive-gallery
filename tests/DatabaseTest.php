<?php

namespace DavideCasiraghi\ResponsiveGallery\Tests;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\DB;

use \Mockery\Adapter\Phpunit\MockeryTestCase;

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
        
        $returnValue = new DB();
            $returnValue->last = "date";
        
    
        $mock = \Mockery::mock('DB');        
        $mock->shouldReceive('get')
            ->with()
            ->once()
            ->andReturn($returnValue);
        
        $book = $mock->get();
        var_dump($book);
        
        
        
        
        
    
        
    }
    
    
    
    
    /** @test */
    /*public function it_gets_photo_data_from_db()
    {
        DB::shouldReceive("raw")
           ->set('query', 'query test')
           ->andReturn(true);
    }
    */
}
