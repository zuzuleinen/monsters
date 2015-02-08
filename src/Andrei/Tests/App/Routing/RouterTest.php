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
        $router->addRoute(new Route('/user/{id}/admin/{adminId}', 'UserController', 'indexAction'));
        $router->addRoute(new Route('/monster/{id}', 'UserController', 'indexAction'));
        
        $apiResult = $router->match('/api');
        $apiResultWithTrailing = $router->match('/api/');
        $resultWithSlugs = $router->match('/user/22/admin/102/');
        $resultSlugWithoutTrailing = $router->match('/monster/12');
        
        $this->assertInstanceOf('Andrei\App\Routing\Route', $apiResult['route']);
        $this->assertInstanceOf('Andrei\App\Routing\Route', $apiResultWithTrailing['route']);
        
        $this->assertInstanceOf('Andrei\App\Routing\Route', $resultWithSlugs['route']);
        $this->assertInternalType('array', $resultWithSlugs['params']);
        $this->assertArrayHasKey('id',  $resultWithSlugs['params']);
        $this->assertArrayHasKey('adminId',  $resultWithSlugs['params']);
        $this->assertEquals(22, $resultWithSlugs['params']['id']);
        $this->assertEquals(102, $resultWithSlugs['params']['adminId']);
        
        
        $this->assertInstanceOf('Andrei\App\Routing\Route', $resultSlugWithoutTrailing['route']);
        $this->assertInternalType('array', $resultSlugWithoutTrailing['params']);
        $this->assertArrayHasKey('id',  $resultSlugWithoutTrailing['params']);
        $this->assertEquals(12, $resultSlugWithoutTrailing['params']['id']);
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
