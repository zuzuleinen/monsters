<?php

namespace Andrei\Game\Response;

/**
 * Generic class for success response
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class SuccessResponse
{
    /**
     * Get array for success response
     * 
     * @return array
     */
    public static function getContent()
    {
        return array(
            'success' => true
        );
    }
}
