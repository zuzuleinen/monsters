<?php

namespace Andrei\App\Routing;

use Andrei\App\Http\Request;

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
     * Match a Request against a Route
     * @param Request $request
     * @return array An array containing the `route` and `params` 
     * from slugs
     * @throws \Exception
     */
    public function match(Request $request)
    {
        $requestUri = $request->getRequestUri();
        
        if (substr($requestUri, -1) !== '/') {
            $requestUri .= '/';
        }

        $returnResult = array('route' => null, 'params' => array());

        /* @var $route Route */
        foreach ($this->routes as $route) {
            if ($requestUri === $route->getPath()) {
                $returnResult['route'] = $route;
                return $returnResult;
            }

            if (preg_match_all('#\{\w+\}#', $route->getPath(), $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
                $variablesNames = array();
                $variablesValues = array();

                //get slugs names from route path
                foreach ($matches as $match) {
                    $slugName = substr($match[0][0], 1, -1);
                    $variablesNames[] = $slugName;
                }

                //get slug values from request uri
                $variablesValues = array_filter(explode('/', $requestUri), function($var) use($route) {
                    if (empty($var) || (strpos($route->getPath(), $var) !== false)) {
                        return false;
                    }
                    return true;
                });

                if (preg_match($this->getPatternFromRoutePath($route->getPath()), $requestUri)) {
                    //create a slug => slugValue array
                    $params = array_combine($variablesNames, $variablesValues);

                    $returnResult['route'] = $route;
                    $returnResult['params'] = $params;
                    return $returnResult;
                }
            }
        }

        throw new \Exception(sprintf('No route was found for request path %s', $requestUri));
    }

    /**
     * Get regex pattern from route path in order to be matched
     * against request uri
     * 
     * @param string $routePath
     * @return string
     */
    private function getPatternFromRoutePath($routePath)
    {
        $patternFromRoutePath = preg_replace('#/#', '\/', $routePath);

        return '/' . preg_replace('#\{\w+\}#', '\d+', $patternFromRoutePath) . '/';
    }
}
