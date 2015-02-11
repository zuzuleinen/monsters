<?php

namespace Andrei\Game\Monster;

use Andrei\Game\Monster\Races;

/**
 * Elf monster class
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class ElfMonster extends AbstractMonster
{   
    /**
     * Get race identifier
     * 
     * @return string
     */
    public function getRace()
    {
        return Races::RACE_ELF;
    }
    
    /**
     * Get elf defense. Elf has 20% defense bonus
     * 
     * @return float
     */
    public function getDefense()
    {
        $defaultDefense = parent::getDefense();
        
        return $defaultDefense + (20/100) * $defaultDefense;
    }
}
