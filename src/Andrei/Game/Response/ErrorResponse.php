<?php

namespace Andrei\Game\Response;

/**
 * Generic error response
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class ErrorResponse
{
    /**
     * Messages strings
     */
    const MSG_METHOD_NOT_ALLOWED = 'Method not allowed';
    
    /**
     * Error message
     * 
     * @var string 
     */
    protected $message;
    
    /**
     * Error message
     * 
     * @param string $message
     */
    public function __construct($message = null)
    {
        $this->message = $message;
    }
    
    /**
     * Get error response content
     * 
     * @return array
     */
    public function getContent()
    {
        return array(
            'success' => false,
            'message' => $this->message
        ); 
    }
}
