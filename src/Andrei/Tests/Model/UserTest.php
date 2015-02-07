<?php

namespace Andrei\Tests\Model;

use Andrei\Model\User;

class UserTest extends \PHPUnit_Framework_TestCase
{

    public function testGetColumnsWillGetAllPropertiesSuffixedWithColumn()
    {
        $user = new User();

        $columns = $user->getColumns();

        $this->assertInternalType('array', $columns);
        $this->assertCount(4, $columns);

        $this->assertTrue(in_array('id', $columns));
        $this->assertTrue(in_array('email', $columns));
        //camel cases will be under scored
        $this->assertTrue(in_array('first_name', $columns));
        $this->assertTrue(in_array('last_name', $columns));
    }

    public function testGetTable()
    {
        $user = new User();

        $this->assertEquals('users', $user->getTable());
    }

    public function testIsPrimaryKey()
    {
        $user = new User();
        
        $this->assertTrue($user->isPrimaryKey('id'));
    }
}
