<?php

namespace Andrei\Game\Monster;

use Andrei\Game\Monster\Races;

/**
 * Not all humans are monsters, but hey this is 
 * a game of fearless monsters :)
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class HumanMonster extends AbstractMonster
{
    /**
     * Get human race
     * 
     * @return string
     */
    public function getRace()
    {
        return Races::RACE_HUMAN;
    }
    
    /**
     * Get human gold. Human will have 30% gold bonus
     * 
     * @return float
     */
    public function getGold()
    {
        $defaultGold = parent::getGold();
        
        return $defaultGold + (30/100) * $defaultGold;
    }
}
