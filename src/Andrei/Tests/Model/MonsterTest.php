<?php

namespace Andrei\Tests\Model;

use Andrei\Model\Monster;
use Andrei\Game\Monster\Races;

class MonsterTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersSetters()
    {
        $monsterModel = new Monster();
        
        $monsterModel->setRace(Races::RACE_HUMAN);
        $monsterModel->setGold(100);
        $monsterModel->setLevel(7);
        $monsterModel->setAttack(100);
        $monsterModel->setDefense(23);
        $monsterModel->setTurns(44);
        $monsterModel->setIsAlive(1);
        
        $this->assertEquals(Races::RACE_HUMAN, $monsterModel->getRace());
        $this->assertEquals(100, $monsterModel->getGold());
        $this->assertEquals(7, $monsterModel->getLevel());
        $this->assertEquals(100, $monsterModel->getAttack());
        $this->assertEquals(23, $monsterModel->getDefense());
        $this->assertEquals(44, $monsterModel->getTurns());
        $this->assertEquals(1, $monsterModel->getIsAlive());
    }
}
