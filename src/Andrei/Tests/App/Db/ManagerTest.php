<?php

namespace Andrei\Tests\App\Db;

use Andrei\App\Db\Manager;
use Andrei\Model\User;
use Andrei\App\Application;

class ManagerTest extends \PHPUnit_Framework_TestCase
{

    protected $connectionStub;
    protected $applicationTest;
    protected $requestStub;

    protected function setUp()
    {
        $this->connectionStub = $this->getMockBuilder('\Andrei\App\Db\ConnectionIterface')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->requestStub = $this->getMockBuilder('\Andrei\App\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $this->applicationTest = new Application(new \Andrei\App\Config(), $this->requestStub, false);
    }

    public function testGetStatementForInsertModel()
    {
        $manager = new Manager($this->connectionStub);

        $expectedStatement = 'INSERT INTO users (email, first_name, last_name) '
            . 'VALUES (:email, :first_name, :last_name)';
        $statement = $manager->getInsertStatementForModel(new User());

        $this->assertEquals($expectedStatement, $statement);
    }

    public function testGetSelectStatementForModel()
    {
        $manager = new Manager($this->connectionStub);

        $statement = $manager->getSelectStatementForModel(
            new User(), array(
            array('firstName', '=', 'Andrei'),
            array('age', '>', 20)
            )
        );

        $expectedStatement = 'SELECT * FROM users WHERE first_name = :first_name AND age > :age';

        $this->assertEquals($expectedStatement, $statement);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid criteria given for select statement
     */
    public function testGetSelectStatementWithInvalidCriteriaGive()
    {
        $manager = new Manager($this->connectionStub);

        $manager->getSelectStatementForModel(new User(), array('xx'));
        $manager->getSelectStatementForModel(new User(), array(array('name')));
    }

    public function testGetDeleteStatementForModel()
    {
        $manager = new Manager($this->connectionStub);

        $statement = $manager->getDeleteStatementForModel(
            new User(), array(
            array('firstName', '=', 'Andrei'),
            array('age', '>', 20)
            )
        );

        $expectedStatement = 'DELETE FROM users WHERE first_name = :first_name AND age > :age';

        $this->assertEquals($expectedStatement, $statement);
    }

    public function testIfCriteriaIsNotProvidedForDelete()
    {
        $manager = new Manager($this->connectionStub);

        $statement = $manager->getDeleteStatementForModel(new User());

        $expectedStatement = 'DELETE FROM users';

        $this->assertEquals($expectedStatement, $statement);
    }

    public function testIfCriteriaIsNotProvidedForSelect()
    {
        $manager = new Manager($this->connectionStub);

        $statement = $manager->getSelectStatementForModel(
            new User()
        );

        $expectedStatement = 'SELECT * FROM users';

        $this->assertEquals($expectedStatement, $statement);
    }

    public function testGetUpdateStatementForModel()
    {
        $user = new User();

        $manager = new Manager($this->connectionStub);

        $user->setEmail('andrey.boar@gmail.com');
        $user->setFirstname('Andrei');
        $user->setLastName('Boar');

        $statement = $manager->getUpdateStatementForModel($user);

        $expectedStatement = 'UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name WHERE id = :id';

        $this->assertEquals($expectedStatement, $statement);
    }
    
    /**
     * Test all CRUD operation for User model
     */
    public function testCrud()
    {
        $user = new User();

        $manager = $this->applicationTest->getManager();

        $user->setEmail('andrey.boar@gmail.com');
        $user->setFirstname('Andrei');
        $user->setLastName('Boar');

        $result = $manager->insert($user);
        
        //user is created in the database
        $this->assertInstanceOf('Andrei\Model\User', $result);
        
        //test by selecting the user
        $users = $manager->select(new User(), array(array('email', '=', 'andrey.boar@gmail.com')));
        $this->assertInternalType('array', $users);
        foreach ($users as $user) {
            $this->assertInstanceOf('Andrei\Model\User', $user);
        }
        
        //update user 
        $updatedUser = array_pop($users);
        $updatedUser->setFirstname('John');
        $manager->update($user);
        
        //delete users and cleanup database
        foreach ($users as $user) {
            $this->assertTrue($manager->delete($user));
        }
        $this->assertTrue($manager->delete($updatedUser));
    }
}
