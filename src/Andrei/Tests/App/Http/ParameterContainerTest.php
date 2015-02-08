<?php

namespace Andrei\Tests\App\Http;

use Andrei\App\Http\ParameterContainer;

class ParameterContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testSetAndAll()
    {
        $parameterContainer = new ParameterContainer();

        $test = array('name' => 'Andrei');

        $parameterContainer->set($test);

        $result = $parameterContainer->all();

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
    }

    public function testGet()
    {
        $parameterContainer = new ParameterContainer();

        $test = array('name' => 'Andrei');

        $parameterContainer->set($test);

        $result = $parameterContainer->get('name');

        $this->assertEquals('Andrei', $result);
    }

    public function testAdd()
    {
        $parameterContainer = new ParameterContainer();
        $parameterContainer->add('name', 'Andrei');
        $parameterContainer->add('age', 25);
        
        $this->assertCount(2, $parameterContainer->all());
    }
}
