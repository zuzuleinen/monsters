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
    const MSG_ATTACKER_NOT_FOUND = 'Attacker model not found for provided id';
    const MSG_DEFENSER_NOT_FOUND = 'Defenser model not found for provided id';
    const MSG_ATTACKER_NOT_ALIVE = 'Attacker model is not alive';
    const MSG_DEFENSER_NOT_ALIVE = 'Defenser model is not alive';
    const MSG_NO_TURNS_LEFT = 'Model has no more turns left';
    
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
