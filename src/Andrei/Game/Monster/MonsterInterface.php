<?php

namespace Andrei\Game\Monster;

/**
 * Implement this interface for each 
 * type of monster you want to create
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
interface MonsterInterface
{   
    /**
     * Get monster race
     */
    public function getRace();
    
    /**
     * Get monster gold amount
     */
    public function getGold();
    
    /**
     * Get monster level
     */
    public function getLevel();
    
    /**
     * Get monster attack points
     */
    public function getAttack();
    
    /**
     * Get monster defense points
     */
    public function getDefense();
    
    /**
     * Get monster turns number
     */
    public function getTurns();
    
    /**
     * Get if monster is alive
     */
    public function getIsAlive();
}