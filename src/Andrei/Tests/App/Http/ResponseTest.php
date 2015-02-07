<?php

namespace Andrei\Tests\App\Http;

use Andrei\App\Http\Response\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Response content must be a string value
     */
    public function testContentMustBeAString()
    {
        new Response(array());
    }
    
    public function testRender()
    {
        $stringValue = 'Hello World!';
        
        $response = new Response($stringValue);
        
        $this->expectOutputString($stringValue);
        $response->render();
    }
}
