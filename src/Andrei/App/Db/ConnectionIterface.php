<?php

namespace Andrei\App\Db;

/**
 * Interface for connection class
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
interface ConnectionIterface
{   
    /**
     * Get \PDO instance
     */
    public function getPdo();
}