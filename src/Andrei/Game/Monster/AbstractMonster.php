<?php

namespace Andrei\Game\Monster;

use Andrei\Model\Monster;

/**
 * Abstract monster class. Each monster type
 * should extend this class. If for some reason
 * a there is another type of monster with a different model 
 * asssociated a similar class can be created and have a new
 * model injected into it
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
abstract class AbstractMonster implements MonsterInterface
{

    /**
     * 
     * @var Monster 
     */
    protected $model;

    /**
     * Inject model
     * 
     * @param Monster $monsterModel
     */
    public function __construct(Monster $monsterModel)
    {
        $this->model = $monsterModel;
    }
    
    /**
     * Get model
     * 
     * @return Monster
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get attack points
     * 
     * @return int
     */
    public function getAttack()
    {
        return (int) $this->model->getAttack();
    }
    
    /**
     * Set defense points
     * 
     * @param float $defensePoints
     */
    public function setDefense($defensePoints)
    {
        $this->model->setDefense($defensePoints);
    }

    /**
     * Get defense points
     * 
     * @return int
     */
    public function getDefense()
    {
        return (int) $this->model->getDefense();
    }

    /**
     * Get gold amount
     * 
     * @return int
     */
    public function getGold()
    {
        return $this->model->getGold();
    }

    /**
     * Get monster level
     * 
     * @return int
     */
    public function getLevel()
    {
        return (int) $this->model->getLevel();
    }
    
    /**
     * Set turns
     * 
     * @param int $turns
     */
    public function setTurns($turns)
    {
        $this->model->setTurns($turns);
    }

    /**
     * Get number of turns
     * 
     * @return int
     */
    public function getTurns()
    {
        return (int) $this->model->getTurns();
    }
    
    /**
     * Set is alive
     * 
     * @param bool $isAlive
     */
    public function setIsAlive($isAlive)
    {
        $this->model->setIsAlive($isAlive);
    }

    /**
     * Get if monster is alive
     * 
     * @return bool
     */
    public function getIsAlive()
    {
        return (bool) $this->model->getIsAlive();
    }
}
