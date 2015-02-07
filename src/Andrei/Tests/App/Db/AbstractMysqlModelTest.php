<?php

namespace Andrei\Tests\App\Db;

class AbstractMysqlModelTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Table name is not set on the model
     */
    public function testIfNotTableIsSetThanException()
    {
        $this->getMockBuilder('\Andrei\App\Db\AbstractMysqlModel')
            ->getMock();
    }
}
