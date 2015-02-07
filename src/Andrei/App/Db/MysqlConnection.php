<?php

namespace Andrei\App\Db;

/**
 * MysqlConnection connection class
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class MysqlConnection implements ConnectionIterface
{
    /**
     * Database host
     * 
     * @var string 
     */
    protected $host;
    
    /**
     * Databse name
     * 
     * @var string 
     */
    protected $dbName;
    
    /**
     * Database user
     * 
     * @var string 
     */
    protected $user;
    
    /**
     * Database password
     * 
     * @var string 
     */
    protected $password;
    
    /**
     * Init connection
     * 
     * @param string $host
     * @param string $dbName
     * @param string $user
     * @param string $password
     */
    public function __construct($host, $dbName, $user = null, $password = null)
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;
    }
    
    /**
     * Get \PDO instance
     * 
     * @return \PDO
     */
    public function getPdo()
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;', $this->host, $this->dbName);
        
        return new \PDO($dsn, $this->user, $this->password);
    }
}
