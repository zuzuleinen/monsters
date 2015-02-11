<?php

namespace Andrei\Controller;

use Andrei\Model\Monster;
use Andrei\Game\Monster\FactoryMonster;
use Andrei\Game\Response\MonsterResponse;
use Andrei\App\Http\Response\JsonResponse;
use Andrei\App\AbstractController;
use Andrei\Game\Response\ErrorResponse;
use Andrei\Game\Monster\AttackService;

/**
 * Attack controller
 * 
 * GET api/monsters/{attackerId}/{defenserId}/ 
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class AttackController extends AbstractController
{

    /**
     * Perfom a fight between monsters
     * GET /api/monsters/{attackerId}/{defenserId}
     * 
     * @param int $attackerId
     * @param int $defenserId
     * @return JsonResponse
     */
    public function attackAction($attackerId, $defenserId)
    {
        $manager = $this->application->getManager();

        $attackerModel = $manager->findById(new Monster, $attackerId);
        $defenserModel = $manager->findById(new Monster, $defenserId);


        if (!$attackerModel instanceof Monster) {
            return $this->getErrroResponse(404, ErrorResponse::MSG_ATTACKER_NOT_FOUND);
        }
        if (!$defenserModel instanceof Monster) {
            return $this->getErrroResponse(404, ErrorResponse::MSG_DEFENSER_NOT_FOUND);
        }

        if (!$attackerModel->getIsAlive()) {
            return $this->getErrroResponse(404, ErrorResponse::MSG_ATTACKER_NOT_ALIVE);
        }

        if (!$defenserModel->getIsAlive()) {
            return $this->getErrroResponse(404, ErrorResponse::MSG_DEFENSER_NOT_ALIVE);
        }

        $attacker = new FactoryMonster($attackerModel);
        $defenser = new FactoryMonster($defenserModel);

        $attackerMonster = $attacker->loadMonster();
        $defenserMonster = $defenser->loadMonster();

        if ($attackerMonster->getTurns() === 0) {
            return $this->getErrroResponse(400, ErrorResponse::MSG_NO_TURNS_LEFT);
        }

        $attackService = new AttackService($attackerMonster, $defenserMonster);
        $result = $attackService->handleFight();

        $manager->update($result['attacker']);
        $manager->update($result['defenser']);

        return new JsonResponse(array(
            MonsterResponse::getResponseObjectFromMonster($result['attacker']),
            MonsterResponse::getResponseObjectFromMonster($result['defenser']),
        ));
    }
}
