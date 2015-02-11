<?php

namespace Andrei\Game\Monster;

use Andrei\Game\Monster\Races;

/**
 * Orc monster class
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class OrcMonster extends AbstractMonster
{   
    /**
     * Get race identifier
     * 
     * @return string
     */
    public function getRace()
    {
        return Races::RACE_ORC;
    }
    
    /**
     * Get orc attack. Orc has 40% bonus attack
     * @return float
     */
    public function getAttack()
    {
        $defaultAttack = parent::getAttack();
        
        return $defaultAttack + (40/100) * $defaultAttack;
    }
}
