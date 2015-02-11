<?php

namespace Andrei\Tests\App\Game\Monster;

use Andrei\Game\Monster\ElfMonster;

class ElfMonsterTest extends \PHPUnit_Framework_TestCase
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
        $elfMonster = new ElfMonster($this->monsterModelMock);
        
        $this->assertEquals('elf', $elfMonster->getRace());
    }
    
    public function testDefense()
    {
        $this->monsterModelMock->expects($this->any())
            ->method('getDefense')
            ->willReturn(100);
        
        $elfMonster = new ElfMonster($this->monsterModelMock);
        
        $this->assertEquals(120, $elfMonster->getDefense());
    }
}
