<?php

namespace Andrei\Game\Monster;

use Andrei\Game\Monster\AbstractMonster;

/**
 * AttackService class responsible for performing 
 * a fight between 2 monsters
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class AttackService
{

    /**
     * @var AbstractMonster 
     */
    protected $attackerMonster;

    /**
     * @var AbstractMonster 
     */
    protected $defenserMonster;
    
    /**
     * Inject monsters
     * 
     * @param AbstractMonster $attackerMonster
     * @param AbstractMonster $defenserMonster
     */
    public function __construct(AbstractMonster $attackerMonster, AbstractMonster $defenserMonster)
    {
        $this->attackerMonster = $attackerMonster;
        $this->defenserMonster = $defenserMonster;
    }
    
    /**
     * Handler fight between 2 monsters
     * 
     * @return array attacker and defenser models
     */
    public function handleFight()
    {
        $secondMonsterDefense = $this->defenserMonster->getDefense() - (10 / 100) * $this->attackerMonster->getAttack();

        $this->defenserMonster->setDefense($secondMonsterDefense);
        if ($secondMonsterDefense < 0) {
            $this->defenserMonster->getModel()->setIsAlive(false);
        }
        $this->attackerMonster->setTurns($this->attackerMonster->getTurns() - 1);
        
        return array(
            'attacker' => $this->attackerMonster->getModel(),
            'defenser' => $this->defenserMonster->getModel()
        );
    }
}
