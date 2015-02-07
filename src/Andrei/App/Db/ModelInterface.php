<?php

namespace Andrei\App\Db;

interface ModelInterface
{
    public function generateSaveSql();
    public function generateDeleteSql();
    public function generateFindBy();
}
