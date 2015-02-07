<?php

namespace Andrei\App\Db;

use Andrei\App\Helper;

/**
 * Manager class responsible for making CRUD 
 * operation to a model
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Manager
{

    /**
     * @var ConnectionIterface 
     */
    protected $connection;

    public function __construct(ConnectionIterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Insert model into database
     * 
     * @param \Andrei\App\Db\AbstractMysqlModel $model
     * @return bool True on success, false on failure
     */
    public function insert(AbstractMysqlModel $model)
    {
        $pdo = $this->connection->getPdo();

        $statement = $this->getInsertStatementForModel($model);

        $pdoStatement = $pdo->prepare($statement);

        foreach ($model->getColumns() as $columnName) {
            if ($model->isPrimaryKey($columnName)) {
                continue;
            }
            $methodToCall = 'get' . ucfirst(Helper::underscoredToCamelCase($columnName));
            $pdoStatement->bindParam(sprintf(':%s', $columnName), $model->$methodToCall());
        }

        return $pdoStatement->execute();
    }

    /**
     * Select models based on criterias
     * 
     * @param \Andrei\App\Db\AbstractMysqlModel $model
     * @param array $criterias
     * @return List of AbstractMysqlModel
     */
    public function select(AbstractMysqlModel $model, $criterias = array())
    {
        $pdo = $this->connection->getPdo();
        $models = array();

        $statement = $this->getSelectStatementForModel($model, $criterias);

        /* @var $pdoStatement \PDOStatement */
        $pdoStatement = $pdo->prepare($statement);

        foreach ($criterias as $criteria) {
            $pdoStatement->bindParam(sprintf(':%s', Helper::underscoredToCamelCase($criteria[0])), $criteria[2]);
        }
        $pdoStatement->execute();
        $rows = $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $model = new $model;
            foreach ($row as $columnName => $columnValue) {
                $methodToCall = 'set' . ucfirst(Helper::underscoredToCamelCase($columnName));
                $model->$methodToCall($columnValue);
            }
            $models[] = $model;
        }

        return $models;
    }
    
    /**
     * Update a model in the database
     * @param \Andrei\App\Db\AbstractMysqlModel $model
     * @return bool
     * @throws Exception
     */
    public function update(AbstractMysqlModel $model)
    {
        if (!$model->getId()) {
            throw new Exception('Model does not have an id.');
        }
        $pdo = $this->connection->getPdo();

        $updateStatement = $this->getUpdateStatementForModel($model);

        $pdoStatement = $pdo->prepare($updateStatement);

        foreach ($model->getColumns() as $columnName) {
            $methodToCall = 'get' . ucfirst(Helper::underscoredToCamelCase($columnName));
            $pdoStatement->bindParam(sprintf(':%s', $columnName), $model->$methodToCall());
        }

        return $pdoStatement->execute();
    }

    /**
     * Delete model from database
     * 
     * @param \Andrei\App\Db\AbstractMysqlModel $model
     * @return bool True on success, False on error
     */
    public function delete(AbstractMysqlModel $model)
    {
        $pdo = $this->connection->getPdo();

        $statement = $this->getDeleteStatementForModel($model);

        /* @var $pdoStatement \PDOStatement */
        $pdoStatement = $pdo->prepare($statement);

        return $pdoStatement->execute();
    }

    /**
     * Get raw insert SQL for an insert
     * 
     * @param AbstractMysqlModel $model
     * @return string
     */
    public function getInsertStatementForModel(AbstractMysqlModel $model)
    {
        $columns = $model->getColumns();

        $columnsString = '(';
        $valuesString = 'VALUES (';
        foreach ($columns as $columnName) {
            if ($model->isPrimaryKey($columnName)) {
                continue;
            }
            $columnsString .= sprintf('%s, ', $columnName);
            $valuesString .= sprintf(':%s, ', $columnName);
        }
        $columnsString = substr($columnsString, 0, -2) . ')';
        $valuesString = substr($valuesString, 0, -2) . ')';

        $statement = sprintf(
            'INSERT INTO %s %s %s', $model->getTable(), $columnsString, $valuesString
        );

        return $statement;
    }

    /**
     * Get raw SQL for select statament. If criterias is omitted
     * than all results will be fetched
     * 
     * @param AbstractMysqlModel $model
     * @param array $criterias
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getSelectStatementForModel(AbstractMysqlModel $model, $criterias = array())
    {
        $selectClause = sprintf('SELECT * FROM %s', $model->getTable());

        if (empty($criterias)) {
            return $selectClause;
        }

        $whereClause = 'WHERE ';

        $i = 0;
        foreach ($criterias as $criteria) {
            if (!is_array($criteria) || count($criteria) !== 3 || !isset($criteria[0], $criteria[1])) {
                throw new \InvalidArgumentException('Invalid criteria given for select statement');
            }

            $columnName = Helper::camelCaseToUnderscored($criteria[0]);
            $sign = $criteria[1];

            if ($i > 0) {
                $whereClause .= ' AND ';
            }

            $whereClause .= sprintf('%s %s :%s', $columnName, $sign, $columnName);
            $i++;
        }

        return sprintf('%s %s', $selectClause, $whereClause);
    }

    /**
     * Get raws SQL for a delete statement. If criterias 
     * are omitted than all rows will be deleted
     * 
     * @param AbstractMysqlModel $model
     * @param array $criterias
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getDeleteStatementForModel(AbstractMysqlModel $model, array $criterias = array())
    {
        $selectClause = sprintf('DELETE FROM %s', $model->getTable());

        if (empty($criterias)) {
            return $selectClause;
        }

        $whereClause = 'WHERE ';

        $i = 0;
        foreach ($criterias as $criteria) {
            if (!is_array($criteria) || count($criteria) !== 3 || !isset($criteria[0], $criteria[1])) {
                throw new \InvalidArgumentException('Invalid criteria given for select statement');
            }

            $columnName = Helper::camelCaseToUnderscored($criteria[0]);
            $sign = $criteria[1];

            if ($i > 0) {
                $whereClause .= ' AND ';
            }

            $whereClause .= sprintf('%s %s :%s', $columnName, $sign, $columnName);
            $i++;
        }

        return sprintf('%s %s', $selectClause, $whereClause);
    }

    /**
     * Get raw SQL for an update statement
     * 
     * @param AbstractMysqlModel $model
     * @return string
     */
    public function getUpdateStatementForModel(AbstractMysqlModel $model)
    {
        $updateClause = sprintf('UPDATE %s SET ', $model->getTable());

        $columns = $model->getColumns();

        foreach ($columns as $columnName) {
            if ($model->isPrimaryKey($columnName)) {
                continue;
            }
            $updateClause .= sprintf('%s = :%s, ', $columnName, $columnName);
        }

        $updateClause = substr($updateClause, 0, -2);
        $updateClause .= sprintf(' WHERE %s = :%s', $model->getPrimaryKeyName(), $model->getPrimaryKeyName());

        return $updateClause;
    }
}
