<?php

namespace Andrei\Tests\App;

use Andrei\App\Helper;

class HelperTest extends \PHPUnit_Framework_TestCase
{
    public function testCamelCaseToUnderscored()
    {
        $this->assertEquals('my_name', Helper::camelCaseToUnderscored('myName'));
        $this->assertEquals('my_awesome_bike', Helper::camelCaseToUnderscored('myAwesomeBike'));
    }
    
    public function testUnderscoredToCamelCase()
    {
        $this->assertEquals('myName', Helper::underscoredToCamelCase('my_name'));
        $this->assertEquals('myFirstName', Helper::underscoredToCamelCase('my_first_name'));
    }

    public function testHasTrailingSlash()
    {
        $this->assertTrue(Helper::hasTrailingSlash('api/'));
        $this->assertTrue(Helper::hasTrailingSlash('api//'));
        $this->assertFalse(Helper::hasTrailingSlash('api'));
    }
}

