<?php

namespace Andrei\App\Db;

use Andrei\App\Helper;

/**
 * Model for Mysql tables. Child classes must extend this
 * add the table name into $table and then list all column as
 * properties suffixed with Column. eg. nameColumn
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
abstract class AbstractMysqlModel
{

    /**
     * Table name
     * 
     * @var string 
     */
    protected $table;

    /**
     * Primary key column
     * 
     * @var string 
     */
    protected $primaryKey = 'id';
    
    /**
     * Column for id
     * 
     * @var int 
     */
    protected $idColumn;

    /**
     * Init model
     * 
     * @throws \Exception
     */
    public function __construct()
    {
        if (!$this->table) {
            throw new \Exception('Table name is not set on the model');
        }
    }
    
    /**
     * Set id
     * @param string $id
     */
    public function setId($id)
    {
        $this->idColumn = $id;
        
        return $this;
    }

    /**
     * Get id 
     * 
     * @return int
     */
    public function getId()
    {
        return $this->idColumn;
    }

    /**
     * Get model column names
     * 
     * @return array
     */
    public function getColumns()
    {
        $columns = array();

        $properties = array_keys(get_object_vars($this));

        foreach ($properties as $property) {
            $count = 0;
            $columnName = str_replace('Column', '', $property, $count);
            if ($count) {
                $columns[] = Helper::camelCaseToUnderscored($columnName);
            }
        }

        return $columns;
    }
    
    /**
     * Check if a column is the primary key
     * 
     * @param string $columnName
     * @return bool
     */
    public function isPrimaryKey($columnName)
    {
        return $columnName === $this->primaryKey;
    }
    
    /**
     * Get primary key name
     * 
     * @return string
     */
    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    /**
     * Get table name
     * 
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }
}
