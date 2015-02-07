<?php

namespace Andrei\Tests\App\Routing;

use Andrei\App\Routing\Router;
use Andrei\App\Routing\Route;

class RouterTest extends \PHPUnit_Framework_TestCase
{

    public function testAddRouteAndGetRoutes()
    {
        $router = new Router();

        $this->assertCount(0, $router->getRoutes());

        $router->addRoute(new Route('test', 'SomeController'));

        $this->assertCount(1, $router->getRoutes());
    }
    
    public function testMatchWillReturnCorrespondingRouteForRequestPath()
    {
        $router = new Router();
        
        $router->addRoute(new Route('/api', 'ApiController', 'indexAction'));
        
        $result = $router->match('/api');
        
        $this->assertInstanceOf('Andrei\App\Routing\Route', $result);
    }
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No route was found for request path /test
     */
    public function testIfNoRouteIsFoundExceptionIsThrown()
    {
        $router = new Router();
        
        $router->match('/test');
    }

}
