<?php

namespace Andrei\Model;

use Andrei\App\Db\AbstractMysqlModel;

/**
 * Model class for monster
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Monster extends AbstractMysqlModel
{

    /**
     * Table name
     * 
     * @var string 
     */
    protected $table = 'monsters';

    /**
     * Table columns
     */
    protected $raceColumn;
    protected $goldColumn;
    protected $levelColumn;
    protected $attackColumn;
    protected $defenseColumn;
    protected $turnsColumn;
    protected $isAliveColumn;

    /**
     * Set race
     * 
     * @param string $race
     * @return \Andrei\Model\Monster
     */
    public function setRace($race)
    {
        $this->raceColumn = $race;

        return $this;
    }

    /**
     * Get monster race
     * 
     * @return string
     */
    public function getRace()
    {
        return $this->raceColumn;
    }

    /**
     * Set monster gold
     * 
     * @param string $gold
     * @return \Andrei\Model\Monster
     */
    public function setGold($gold)
    {
        $this->goldColumn = $gold;
        
        return $this;
    }

    /**
     * Get monster gold
     * 
     * @return string
     */
    public function getGold()
    {
        return $this->goldColumn;
    }

    /**
     * Set level
     * 
     * @param string $level
     * @return \Andrei\Model\Monster
     */
    public function setLevel($level)
    {
        $this->levelColumn = $level;
        
        return $this;
    }

    /**
     * Get level
     * 
     * @return string
     */
    public function getLevel()
    {
        return $this->levelColumn;
    }

    /**
     * Set attack points
     * 
     * @param  $attack
     * @return \Andrei\Model\Monster
     */
    public function setAttack($attack)
    {
        $this->attackColumn = $attack;
        
        return $this;
    }

    /**
     * Get attack points
     * 
     * @return string
     */
    public function getAttack()
    {
        return $this->attackColumn;
    }

    /**
     * Set defense points
     * 
     * @param string|int $defense
     * @return \Andrei\Model\Monster
     */
    public function setDefense($defense)
    {
        $this->defenseColumn = $defense;
        
        return $this;
    }

    /**
     * Get defense points
     * 
     * @return string
     */
    public function getDefense()
    {
        return $this->defenseColumn;
    }

    /**
     * Set number of turns
     * 
     * @param string $turns
     * @return \Andrei\Model\Monster
     */
    public function setTurns($turns)
    {
        $this->turnsColumn = $turns;
        
        return $this;
    }

    /**
     * Get number of turns
     * 
     * @return string
     */
    public function getTurns()
    {
        return $this->turnsColumn;
    }

    /**
     * Set is alive
     * 
     * @param bool $isAlive
     * @return \Andrei\Model\Monster
     */
    public function setIsAlive($isAlive)
    {
        $this->isAliveColumn = (bool) $isAlive;
        
        return $this;
    }

    /**
     * Get is alive
     * 
     * @return bool
     */
    public function getIsAlive()
    {
        return (bool) $this->isAliveColumn;
    }
}
