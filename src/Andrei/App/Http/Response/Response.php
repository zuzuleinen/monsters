<?php

namespace Andrei\App\Http\Response;

/**
 * Simple string response
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Response extends AbstractResponse
{

    /**
     * Set content
     * 
     * @param string $content
     */
    public function setContent($content)
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('Response content must be a string value');
        }

        $this->content = $content;
    }
}
