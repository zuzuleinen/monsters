<?php

namespace Andrei\App;

use Andrei\App\Db\Manager;
use Andrei\App\Config;
use Andrei\App\Http\Request;

/**
 * Application class
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Application
{

    /**
     * Db manager
     * 
     * @var Manager 
     */
    protected $manager;
    
    /**
     * Application configuration
     * 
     * @var Config 
     */
    protected $config;
    
    /**
     * Request object class
     * 
     * @var Request 
     */
    protected $request;


    /**
     * Flag if application is in production mode
     * Otherwise mode is test
     * 
     * @var bool 
     */
    protected $isProduction;
    
    /**
     * Init application
     * 
     * @param Config $config
     * @param bool $isProduction
     */
    public function __construct(Config $config, Request $request, $isProduction = true)
    {
        $this->config = $config;
        $this->request = $request;
        $this->isProduction = $isProduction;
    }
    
    /**
     * Get model manager
     * 
     * @return Manager
     */
    public function getManager()
    {
        if ($this->manager instanceof Manager) {
            return $this->manager;
        }
        
        $this->manager = new Manager($this->config->getConnection($this->isProduction));
        
        return $this->manager;
    }
    
    /**
     * Get request object
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Get application configuration
     * 
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
