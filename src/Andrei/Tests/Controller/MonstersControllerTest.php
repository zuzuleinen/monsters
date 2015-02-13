<?php

namespace Andrei\Tests\Controller;

use Andrei\Controller\MonstersController;
use Andrei\App\Http\ParameterContainer;

class MonstersControllerTest extends \PHPUnit_Framework_TestCase
{

    protected $applicationMock;
    protected $requestMock;
    protected $managerMock;
    protected $humanMonsterMock;
    protected $elfMonsterMock;

    protected function setUp()
    {
        $this->applicationMock = $this->getMockBuilder('\Andrei\App\Application')
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestMock = $this->getMockBuilder('\Andrei\App\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $this->managerMock = $this->getMockBuilder('\Andrei\App\Db\Manager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->applicationMock->expects($this->any())
            ->method('getManager')
            ->willReturn($this->managerMock);

        $this->humanMonsterMock = new \Andrei\Model\Monster();
        $this->humanMonsterMock
            ->setId(8)
            ->setRace('human')
            ->setGold(100)
            ->setLevel(5)
            ->setDefense(23)
            ->setTurns(9)
            ->setIsAlive(true);

        $this->elfMonsterMock = new \Andrei\Model\Monster();
        $this->elfMonsterMock
            ->setId(7)
            ->setRace('elf')
            ->setGold(100)
            ->setLevel(5)
            ->setDefense(23)
            ->setTurns(9)
            ->setIsAlive(true);
    }

    public function testCreateActionSuccess()
    {
        $this->requestMock->post = new ParameterContainer(array(
            'race' => 'human',
            'gold' => 100,
            'level' => 7,
            'attack' => 50,
            'defense' => 23,
            'turns' => 9,
            'isAlive' => false
        ));

        $this->managerMock->expects($this->once())
            ->method('insert')
            ->willReturn($this->humanMonsterMock);

        $controller = $this->getController();
        $response = $controller->createAction();

        $this->assertInstanceOf("\Andrei\App\Http\Response\JsonResponse", $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            '{"id":8,"race":"human","gold":100,"level":5,"attack":0,"defense":23,"turns":9,"isAlive":true}', $response->getContent()
        );
    }

    public function testGetAllActionSuccess()
    {
        $controller = $this->getController();

        $this->managerMock->expects($this->once())
            ->method('select')
            ->willReturn(array($this->humanMonsterMock, $this->elfMonsterMock));

        $response = $controller->getAllAction();

        $this->assertInstanceOf('\Andrei\App\Http\Response\JsonResponse', $response);
        $this->assertEquals('['
            . '{"id":8,"race":"human","gold":100,"level":5,"attack":0,"defense":23,"turns":9,"isAlive":true},'
            . '{"id":7,"race":"elf","gold":100,"level":5,"attack":0,"defense":23,"turns":9,"isAlive":true}'
            . ']', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetAllWhenNoMonsterIsFound()
    {
        $controller = $this->getController();

        $this->managerMock->expects($this->once())
            ->method('select')
            ->willReturn(array());

        $response = $controller->getAllAction();

        $this->assertInstanceOf('\Andrei\App\Http\Response\JsonResponse', $response);
        $this->assertEquals('[]', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteAllSuccess()
    {
        $this->requestMock->post = new ParameterContainer(array(
            'race' => 'human',
            'gold' => 100,
            'level' => 7,
            'attack' => 50,
            'defense' => 23,
            'turns' => 9,
            'isAlive' => false
        ));
        
        $this->managerMock->expects($this->once())
            ->method('deleteAll');

        $controller = $this->getController();

        $response = $controller->deleteAllAction();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"success":true}', $response->getContent());
    }

    public function testUpdateByIdSuccess()
    {
        $id = 8;
        $this->managerMock->expects($this->once())
            ->method('findById')
            ->with(new \Andrei\Model\Monster(), 8)
            ->willReturn($this->humanMonsterMock);

        $this->managerMock->expects($this->once())
            ->method('update')
            ->with($this->humanMonsterMock);
        
        $this->requestMock->put = new ParameterContainer(array(
            'race' => 'human',
            'gold' => 100,
            'level' => 7,
            'attack' => 50,
            'defense' => 23,
            'turns' => 9,
            'isAlive' => false
        ));

        $controller = $this->getController();

        $response = $controller->updateById($id);

        $this->assertEquals(
            '{"id":8,"race":"human","gold":100,"level":7,"attack":50,"defense":23,"turns":9,"isAlive":false}', 
            $response->getContent()
        );
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testGetByIdActionSuccess()
    {
        $id = 8;
        
        $this->managerMock->expects($this->once())
            ->method('findById')
            ->with(new \Andrei\Model\Monster, $id)
            ->willReturn($this->humanMonsterMock);
        
        $controller = $this->getController();
        
        $response = $controller->getByIdAction(8);
        
        $this->assertEquals(
            '{"id":8,"race":"human","gold":100,"level":5,"attack":0,"defense":23,"turns":9,"isAlive":true}', 
            $response->getContent()
        );
        $this->assertEquals(200, $response->getStatusCode());
    }

    protected function getController()
    {
        $monstersController = new MonstersController();

        $monstersController->setApplication($this->applicationMock);
        $monstersController->setRequest($this->requestMock);

        return $monstersController;
    }

}
