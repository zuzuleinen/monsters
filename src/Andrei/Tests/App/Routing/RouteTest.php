<?php

namespace Andrei\Tests\App\Routing;

use Andrei\App\Routing\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{

    public function testRouteInitialization()
    {
        $route = new Route('/api/', 'IndexController', 'testAction');

        $this->assertEquals('/api/', $route->getPath());
        $this->assertEquals('IndexController', $route->getController());
        $this->assertEquals('testAction', $route->getAction());
    }

    public function testIsMethodAllowedForRoute()
    {
        $route = new Route('/api/', 'IndexController', 'testAction', array('POST'));
        
        $this->assertFalse($route->isMethodAllowedForRoute('GET'));
        $this->assertTrue($route->isMethodAllowedForRoute('POST'));
        $this->assertTrue($route->isMethodAllowedForRoute('post'));
    }

}
