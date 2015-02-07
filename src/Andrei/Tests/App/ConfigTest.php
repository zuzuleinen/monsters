<?php

namespace Andrei\Tests\App;

use Andrei\App\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testGetRouter()
    {
        $config = new Config();

        $this->assertInstanceOf('\Andrei\App\Routing\Router', $config->getRouter());
    }

    public function testGetConnection()
    {
        $config = new Config();

        $this->assertInstanceOf('\Andrei\App\Db\MysqlConnection', $config->getConnection());
    }

}
