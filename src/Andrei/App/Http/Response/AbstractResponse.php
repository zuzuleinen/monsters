<?php

namespace Andrei\App\Http\Response;

/**
 * Parent response class. Extend this for each
 * custom response class you want to create
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
abstract class AbstractResponse
{

    /**
     * Content data we want to display
     * 
     * @var string 
     */
    protected $content;

    /**
     * HTTP status code
     * 
     * @var int 
     */
    protected $status;

    /**
     * HTTP headers 
     * 
     * @var array 
     */
    protected $headers = array();

    /**
     * Initialize response 
     * 
     * @param mixed $content
     * @param int $status
     * @param array $headers
     */
    public function __construct($content = '', $status = 200, $headers = array())
    {
        $this->setContent($content);
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * Render response to client with appropriate
     * headers, status code and string content
     */
    public function render()
    {
        foreach ($this->headers as $header) {
            header(sprintf('%s: %s', $header[0], $header[1]));
        }

        http_response_code($this->status);

        echo $this->content;
    }
    
    /**
     * Get response status code
     * 
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status;
    }
    
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content depending on the response type
     */
    public abstract function setContent($content);
}
