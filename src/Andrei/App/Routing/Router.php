<?php

namespace Andrei\App\Routing;

/**
 * Router class responsible for holding information
 * about application routes 
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Router
{

    /**
     * Routes collection
     * 
     * @var array 
     */
    protected $routes = array();

    /**
     * Add Route to router
     * 
     * @param \Andrei\App\Routing\Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * Get routes
     * 
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match a request URI against a Route. 
     * @param string $requestUri
     * @return Route Corresponding route
     * @throws \Exception
     */
    public function match($requestUri)
    {
        /* @var $route Route */
        foreach ($this->routes as $route) {
            if ($requestUri === $route->getPath()) {
                return $route;
            }
        }

        throw new \Exception(sprintf('No route was found for request path %s', $requestUri));
    }
}
