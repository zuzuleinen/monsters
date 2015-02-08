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
}
