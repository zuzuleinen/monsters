<?php

namespace Andrei\App\Http;

/**
 * Parameter container class responsible 
 * for holding request parameters such as
 * GET, POST, PUT, DELETE
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class ParameterContainer
{

    /**
     * Parameters
     * 
     * @var array 
     */
    protected $parameters;

    /**
     * Inject parameters
     * 
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * Set parameters
     * 
     * @param array $parameters
     */
    public function set(array $parameters)
    {
        $this->parameters = $parameters;
    }
    
    /**
     * Get all parameters
     * 
     * @return array
     */
    public function all()
    {
        return $this->parameters;
    }

    /**
     * Get parameter by its key
     * 
     * @param string $key
     * @param mixed $valueIfNotFound
     * @return mixed
     */
    public function get($key, $valueIfNotFound = null)
    {
        return (isset($this->parameters[$key])) ? $this->parameters[$key] : $valueIfNotFound;
    }

    /**
     * Add new parameter to container
     * 
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        $this->parameters[$key] = $value;
    }
}
