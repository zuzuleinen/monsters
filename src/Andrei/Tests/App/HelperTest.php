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
}

