<?php

namespace Andrei\Tests\Game\Monster;

use Andrei\Game\Monster\OrcMonster;

class OrcMonsterTest extends \PHPUnit_Framework_TestCase
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
        $orcMonster = new OrcMonster($this->monsterModelMock);

        $this->assertEquals('orc', $orcMonster->getRace());
    }

    public function testOrcHasAttackBonus()
    {
        $this->monsterModelMock->expects($this->any())
            ->method('getAttack')
            ->willReturn(100);

        $orcMonster = new OrcMonster($this->monsterModelMock);
        
        $this->assertEquals(140, $orcMonster->getAttack());
    }
}
