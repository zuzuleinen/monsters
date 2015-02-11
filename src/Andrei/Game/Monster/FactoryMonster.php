<?php

namespace Andrei\Game\Monster;

/**
 * Factory monster class responsible for loading 
 * the right monster object
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class FactoryMonster
{

    /**
     * @var \Andrei\Model\Monster 
     */
    protected $monsterModel;

    public function __construct($monsterModel)
    {
        $this->monsterModel = $monsterModel;
    }

    /**
     * Load monster object
     * 
     * @return MonsterInterface
     * @throws \InvalidArgumentException
     */
    public function loadMonster()
    {
        switch ($this->monsterModel->getRace()) {
            case Races::RACE_HUMAN:
                return new HumanMonster($this->monsterModel);
            case Races::RACE_ELF:
                return new ElfMonster($this->monsterModel);
            case Races::RACE_ORC:
                return new OrcMonster($this->monsterModel);
            default:
                throw new \InvalidArgumentException('Invalid race for monster');
        }
    }
}
