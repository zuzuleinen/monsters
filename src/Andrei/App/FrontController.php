<?php

namespace Andrei\App;

use Andrei\App\Routing\Route;

/**
 * FrontController class responsible for loading the correct 
 * controller based on the request URI
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class FrontController
{

    /**
     * @var Config 
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function dispatch()
    {
        //@todo create a request object
        $requestUri = $_SERVER['REQUEST_URI'];

        $route = $this->config->getRouter()->match($requestUri);

        if ($route instanceof Route) {
            $response = $this->getResponse($route);
            echo $response->render();
        }
    }

    /**
     * Get Response object from controller action
     * 
     * @param Route $route
     * @return Http\Response\Response
     * @throws \Exception
     */
    protected function getResponse(Route $route)
    {
        $controllerClass = $this->getControllerFullClassName($route->getController());

        $controller = new $controllerClass;

        $actionName = $route->getAction();
        if (!method_exists($controller, $actionName)) {
            throw new \Exception(sprintf('Action `%s` does not exist on controller.', $actionName));
        }
        $response = $controller->$actionName();

        if (!$response instanceof Http\Response\AbstractResponse) {
            throw new \Exception('An action must return an instance of AbstractResponse');
        }

        return $response;
    }

    /**
     * Get controller full class
     * @param string $controllerName
     * @return string
     */
    protected function getControllerFullClassName($controllerName)
    {
        $className = sprintf(
            '%s\%s\\%s', 
            Config::PROJECT_DIR, 
            Config::CONTROLLERS_DIR, 
            $controllerName
        );

        return $className;
    }
}
