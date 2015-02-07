<?php

namespace Andrei\App;

use Andrei\App\Db\Manager;
use Andrei\App\Config;

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
    public function __construct(Config $config, $isProduction = true)
    {
        $this->config = $config;
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
}
