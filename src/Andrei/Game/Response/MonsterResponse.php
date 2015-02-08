<?php

namespace Andrei\Game\Response;

use Andrei\Model\Monster;

/**
 * Monster response class responsible 
 * for fetching array data to use in JSON responses
 * for Monster models
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class MonsterResponse
{

    /**
     * Body response field names
     */
    const ID_FIELD = 'id';
    const RACE_FIELD = 'race';
    const GOLD_FIELD = 'gold';
    const LEVEL_FIELD = 'level';
    const ATTACK_FIELD = 'attack';
    const DEFENSE_FIELD = 'defense';
    const TURNS_FIELD = 'turns';
    const IS_ALIVE_FIELD = 'isAlive';

    /**
     * Get empty response for Monster model
     * 
     * @return array
     */
    public static function getEmptyResponseForMonster()
    {
        $viewResponse = array(
            self::ID_FIELD => null,
            self::RACE_FIELD => null,
            self::GOLD_FIELD => null,
            self::LEVEL_FIELD => null,
            self::ATTACK_FIELD => null,
            self::DEFENSE_FIELD => null,
            self::TURNS_FIELD => null,
            self::IS_ALIVE_FIELD => false
        );

        return $viewResponse;
    }

    /**
     * Get response object for a Monster model
     * 
     * @param Monster $monster
     * @return array
     */
    public static function getResponseObjectFromMonster(Monster $monster)
    {
        $monsterObject = array(
            self::ID_FIELD => $monster->getId(),
            self::RACE_FIELD => $monster->getRace(),
            self::GOLD_FIELD => (int) $monster->getGold(),
            self::LEVEL_FIELD => (int) $monster->getLevel(),
            self::ATTACK_FIELD => (int) $monster->getAttack(),
            self::DEFENSE_FIELD => (int) $monster->getDefense(),
            self::TURNS_FIELD => (int) $monster->getTurns(),
            self::IS_ALIVE_FIELD => (bool) $monster->getIsAlive()
        );

        return $monsterObject;
    }

    /**
     * Get response from list of Monster objects
     * 
     * @param array $monsters List of Monster objects
     * @return array
     * @throws \LogicException
     */
    public static function getResponseObjectForListOfMonsters(array $monsters)
    {
        $response = array();

        foreach ($monsters as $monster) {
            if (!$monster instanceof Monster) {
                throw new \LogicException('Each element of array must be Monster object.');
            }
            $response[] = $this->getResponseObjectFromMonster($monster);
        }

        return $response;
    }
}
