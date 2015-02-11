<?php

namespace Andrei\Tests\App\Routing;

use Andrei\App\Routing\Router;
use Andrei\App\Routing\Route;

class RouterTest extends \PHPUnit_Framework_TestCase
{

    protected $requestStub;

    protected function setUp()
    {
        $this->requestStub = $this->getMockBuilder('\Andrei\App\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();
    }

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

        $this->requestStub->expects($this->any())
            ->method('getRequestUri')
            ->willReturn('/api');
        $this->requestStub->expects($this->any())
            ->method('getRequestMethod')
            ->willReturn('GET');

        $apiResult = $router->match($this->requestStub);
        $this->assertInstanceOf('Andrei\App\Routing\Route', $apiResult['route']);

        $this->requestStub->expects($this->any())
            ->method('getRequestUri')
            ->willReturn('/api/');

        $apiResultWithTrailing = $router->match($this->requestStub);
        $this->assertInstanceOf('Andrei\App\Routing\Route', $apiResultWithTrailing['route']);
    }

    public function testResultWithSlugs()
    {
        $router = new Router();

        $router->addRoute(new Route('/user/{id}/admin/{adminId}', 'UserController', 'indexAction'));

        $this->requestStub->expects($this->any())
            ->method('getRequestUri')
            ->willReturn('/user/22/admin/102/');
        $this->requestStub->expects($this->any())
            ->method('getRequestMethod')
            ->willReturn('GET');

        $resultWithSlugs = $router->match($this->requestStub);

        $this->assertInstanceOf('Andrei\App\Routing\Route', $resultWithSlugs['route']);
        $this->assertInternalType('array', $resultWithSlugs['params']);
        $this->assertArrayHasKey('id', $resultWithSlugs['params']);
        $this->assertArrayHasKey('adminId', $resultWithSlugs['params']);
        $this->assertEquals(22, $resultWithSlugs['params']['id']);
        $this->assertEquals(102, $resultWithSlugs['params']['adminId']);
    }

    public function testResultWithSlugWithoutTrailingSlash()
    {
        $router = new Router();

        $router->addRoute(new Route('/monster/{id}', 'UserController', 'indexAction'));

        $this->requestStub->expects($this->any())
            ->method('getRequestUri')
            ->willReturn('/monster/12');
        $this->requestStub->expects($this->any())
            ->method('getRequestMethod')
            ->willReturn('GET');

        $resultSlugWithoutTrailing = $router->match($this->requestStub);

        $this->assertInstanceOf('Andrei\App\Routing\Route', $resultSlugWithoutTrailing['route']);
        $this->assertInternalType('array', $resultSlugWithoutTrailing['params']);
        $this->assertArrayHasKey('id', $resultSlugWithoutTrailing['params']);
        $this->assertEquals(12, $resultSlugWithoutTrailing['params']['id']);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No route was found for request path /test
     */
    public function testIfNoRouteIsFoundExceptionIsThrown()
    {
        $router = new Router();

        $this->requestStub->expects($this->any())
            ->method('getRequestUri')
            ->willReturn('/test');
        $this->requestStub->expects($this->any())
            ->method('getRequestMethod')
            ->willReturn('GET');

        $router->match($this->requestStub);
    }

}
