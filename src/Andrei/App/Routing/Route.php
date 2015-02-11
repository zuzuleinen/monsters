<?php

namespace Andrei\App\Routing;

use Andrei\App\Helper;

/**
 * Route object class responsible for holding
 * information about a route. Later a $methods 
 * property can be added to restrict only one
 * HTTP method on the route
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Route
{

    /**
     * Route path
     * 
     * @var string 
     */
    protected $path;

    /**
     * Controller name. Same as controller filename
     * 
     * @var string 
     */
    protected $controller;

    /**
     * Action name
     * 
     * @var string 
     */
    protected $action;
    
    /**
     * Allowed request methods
     * 
     * @var array 
     */
    protected $allowedMethods;

    /**
     * Init route information
     * 
     * @param string $path
     * @param string $controller
     * @param string $action
     */
    public function __construct(
        $path, 
        $controller, 
        $action = 'indexAction',
        $allowedMethods = array('GET', 'POST', 'PUT', 'DELETE')
    ) {
        if (!Helper::hasTrailingSlash($path)) {
            $path .= '/';
        }
        
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
        $this->allowedMethods = $allowedMethods;
    }

    /**
     * Get route path
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get controller name
     * 
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get action name
     * 
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * Check if request method is allowed for route
     * 
     * @param string $method
     * @return bool
     */
    public function isMethodAllowedForRoute($method)
    {
        return in_array(strtoupper($method), $this->allowedMethods);
    }
}
