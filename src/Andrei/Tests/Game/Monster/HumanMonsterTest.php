<?php

namespace Andrei\Tests\Game\Monster;

use Andrei\Game\Monster\HumanMonster;

class HumanMonsterTest extends \PHPUnit_Framework_TestCase
{

    protected $monsterModelMock;

    protected function setUp()
    {
        $this->monsterModelMock = $this->getMockBuilder('\Andrei\Model\Monster')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    public function testGetRace()
    {
        $humanMonster = new HumanMonster($this->monsterModelMock);
        
        $this->assertEquals('human', $humanMonster->getRace());
    }
    
    public function testGetGold()
    {
        $this->monsterModelMock->expects($this->any())
            ->method('getGold')
            ->willReturn(100);
        
        $elfMonster = new HumanMonster($this->monsterModelMock);
        
        $this->assertEquals(130, $elfMonster->getGold());
    }
}
