<?php

namespace Andrei\Tests\Game\Monster;

class AttackServiceTest extends \PHPUnit_Framework_TestCase
{

    protected $attackerMonsterMock;
    protected $defenserMonsterMock;

    public function testHandleFight()
    {
        $attackerModel = new \Andrei\Model\Monster();
        $attackerModel->setTurns(10);
        $attackerModel->setAttack(50);

        $defenserModel = new \Andrei\Model\Monster();
        $defenserModel->setDefense(30);

        $this->attackerMonsterMock = new \Andrei\Game\Monster\HumanMonster($attackerModel);

        $this->defenserMonsterMock = new \Andrei\Game\Monster\HumanMonster($defenserModel);
        
        $attackService = new \Andrei\Game\Monster\AttackService(
            $this->attackerMonsterMock, $this->defenserMonsterMock
        );

        $result = $attackService->handleFight();

        $this->assertInstanceOf('\Andrei\Model\Monster', $result['attacker']);
        $this->assertInstanceOf('\Andrei\Model\Monster', $result['defenser']);
        
        //turns of attacker are decremented
        $this->assertEquals(9, $result['attacker']->getTurns());
        //defense of defenser is decremented with 10% of attacker attack
        $this->assertEquals(25, $result['defenser']->getDefense());
    }
}
