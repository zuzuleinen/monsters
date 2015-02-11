<?php

namespace Andrei\App\Http;

use Andrei\App\Http\ParameterContainer;

/**
 * Request object class
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Request
{

    /**
     * @var ParameterContainer 
     */
    public $post;

    /**
     * @var ParameterContainer 
     */
    public $get;

    /**
     * @var ParameterContainer 
     */
    public $put;

    /**
     * @var ParameterContainer 
     */
    public $server;
    
    /**
     * Init request
     * 
     * @param array $post
     * @param array $get
     * @param array $server
     */
    public function __construct($post, $get, $server)
    {
        $this->post = new ParameterContainer($post);
        $this->get = new ParameterContainer($get);
        $this->server = new ParameterContainer($server);

        //init put
        parse_str(file_get_contents("php://input"), $put);
        $this->put = new ParameterContainer($put);
    }
    
    /**
     * Init request object from globals
     * 
     * @return \self
     */
    public static function init()
    {
        return new self($_POST, $_GET, $_SERVER);
    }
    
    /**
     * Check if request method is POST
     * 
     * @return bool
     */
    public function isPost()
    {
        return $this->server->get('REQUEST_METHOD') === 'POST';
    }
    
    /**
     * Check if request method is GET
     * 
     * @return bool
     */
    public function isGet()
    {
        return $this->server->get('REQUEST_METHOD') === 'GET';
    }
    
    /**
     * Check if request method is PUT
     * 
     * @return bool
     */
    public function isPut()
    {
        return $this->server->get('REQUEST_METHOD') === 'PUT';
    }
    
    /**
     * Check if request method is DELETE
     * 
     * @return bool
     */
    public function isDelete()
    {
        return $this->server->get('REQUEST_METHOD') === 'DELETE';
    }
    
    /**
     * Get request URI
     * 
     * @return string
     */
    public function getRequestUri()
    {
        return $this->server->get('REQUEST_URI');
    }
    
    /**
     * Get request method
     * 
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->server->get('REQUEST_METHOD');
    }
}
