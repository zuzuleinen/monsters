<?php

namespace Andrei\App;

use Andrei\App\Routing\Router;
use Andrei\App\Routing\Route;
use Andrei\App\Db\MysqlConnection;

/**
 * Normally application configuration should be stored in files
 * or even as environment variables and then different classes
 * should load them from there.
 * 
 * For the sake of simplicity I will keep here all the configuration, 
 * normally I wouldn't use such a class
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Config
{

    /**
     * My vendor name
     */
    const PROJECT_DIR = 'Andrei';

    /**
     * Controller directory
     */
    const CONTROLLERS_DIR = 'Controller';

    /**
     * @var Router 
     */
    protected $router;
    
    /**
     * Database credentials for production
     */
    const DB_HOST_PROD = 'localhost';
    const DB_DATABASE_PROD = 'monsters';
    const DB_DATABASE_USER_PROD = 'root';
    const DB_DATABASE_PASSWORD_PROD = 'root';
    
    /**
     * Database credentials for unit testing
     */
    const DB_HOST_TEST = 'localhost';
    const DB_DATABASE_TEST = 'monsters_dev';
    const DB_DATABASE_USER_TEST = 'root';
    const DB_DATABASE_PASSWORD_TEST = 'root';

    /**
     * Add here all the routing configuration
     * 
     * @return Router
     */
    public function getRouter()
    {
        if ($this->router) {
            return $this->router;
        }

        $this->router = new Router();

        $this->router->addRoute(new Route('/api/', 'ApiController'));

        return $this->router;
    }
    
    /**
     * Get application connection
     * 
     * @param bool $isProduction
     * @return MysqlConnection
     */
    public function getConnection($isProduction = true)
    {
        if ($isProduction) {
            return new MysqlConnection(
                self::DB_HOST_PROD, 
                self::DB_DATABASE_PROD, 
                self::DB_DATABASE_USER_PROD, 
                self::DB_DATABASE_PASSWORD_PROD
            );
        }
        
        return new MysqlConnection(
                self::DB_HOST_TEST, 
                self::DB_DATABASE_TEST, 
                self::DB_DATABASE_USER_TEST, 
                self::DB_DATABASE_PASSWORD_TEST
            );
    }
}
