<?php

namespace Andrei\App\Http\Response;


/**
 * Response class for JSON responses
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class JsonResponse extends AbstractResponse
{

    /**
     * Init response class
     * 
     * @param array $content An array for json
     * @param int $status HTTP status code
     * @param array $headers
     */
    public function __construct(array $content = array(), $status = 200, $headers = array())
    {
        $headers[] = array('Content-Type', 'application/json');
        parent::__construct($content, $status, $headers);
    }

    /**
     * Set content
     * 
     * @param array $content
     */
    public function setContent($content)
    {
        $data = (is_array($content)) ? $content : array($content);
        
        $this->content = json_encode($data);
    }
}
