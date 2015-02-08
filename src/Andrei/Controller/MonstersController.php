<?php

namespace Andrei\Controller;

use Andrei\App\AbstractController;
use Andrei\App\Http\Response\JsonResponse;
use Andrei\Model\Monster;
use Andrei\Game\Response\MonsterResponse;
use Andrei\Game\Response\ErrorResponse;
use Andrei\App\Http\ParameterContainer;

/**
 * Monsters controller responsible for fetching
 * data about a monster resource
 * 
 * GET /api/monsters/ - get all monsters
 * POST /api/monsters/ - create new monster
 * GET /api/monsters/{id} - get monster by id    
 * PUT /api/monsters/{id} - update monster if exists
 * DELETE /api/monsters - delete all monsters
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class MonstersController extends AbstractController
{

    /**
     * GET /api/monsters/ - get all monsters
     * POST /api/monsters - create new monster
     * DELETE /api/monsters - delete all monsters
     * 
     * @return JsonResponse
     */
    public function indexAction()
    {
        $manager = $this->application->getManager();

        if ($this->request->isDelete()) {
            $manager->deleteAll(new Monster());
            return $this->getSuccessResponse();
        }

        if ($this->request->isPost()) {
            $monster = $this->createMonster($this->request->post);
            return new JsonResponse(MonsterResponse::getResponseObjectFromMonster($monster));
        }

        if ($this->request->isGet()) {
            $monsters = $manager->select(new Monster);

            if (count($monsters)) {
                /* @var $monster Monster */
                $listResponse = MonsterResponse::getResponseObjectForListOfMonsters($monsters);
                return new JsonResponse($listResponse);
            } else {
                return new JsonResponse(array(), 404);
            }
        }

        return $this->getErrroResponse(405, ErrorResponse::MSG_METHOD_NOT_ALLOWED);
    }

    /**
     * Get monster by id action
     * 
     * GET /api/monsters/{id} - get monster by id
     * PUT /api/monsters/{id} - update monster if exists
     * DELETE /api/monsters/{id} - delete monster by id
     * POST is not allowed
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function viewAction($id = null)
    {
        $viewResponse = MonsterResponse::getEmptyResponseForMonster();

        if ($this->request->isPost()) {
            return $this->getErrroResponse(405, ErrorResponse::MSG_METHOD_NOT_ALLOWED);
        }

        $manager = $this->application->getManager();

        if ($this->request->isDelete()) {
            $monster = $manager->findById(new Monster, $id);
            if ($monster instanceof Monster) {
                $manager->delete($monster);
                return $this->getSuccessResponse();
            } else {
                return new JsonResponse(array(), 404);
            }
        }

        if ($this->request->isPut()) {
            $viewResponse = MonsterResponse::getEmptyResponseForMonster();

            $race = $this->request->put->get('race');
            $gold = $this->request->put->get('gold');
            $level = $this->request->put->get('level');
            $attack = $this->request->put->get('attack');
            $defense = $this->request->put->get('defense');
            $turns = $this->request->put->get('turns');
            $isAlive = $this->request->put->get('isAlive');

            $monster = $manager->findById(new Monster, $id);

            if ($monster instanceof Monster) {
                $monster->setRace($race)
                    ->setGold($gold)
                    ->setLevel($level)
                    ->setAttack($attack)
                    ->setDefense($defense)
                    ->setTurns($turns)
                    ->setIsAlive($isAlive);

                $manager->update($monster);
                return new JsonResponse(MonsterResponse::getResponseObjectFromMonster($monster));
            }
            return new JsonResponse($viewResponse, 404);
        }

        if ($id) {
            /* @var $monster Monster */
            $monster = $manager->findById(new Monster, $id);

            if ($monster instanceof Monster) {
                $viewResponse = MonsterResponse::getResponseObjectFromMonster($monster);
            }
        }
        return new JsonResponse($viewResponse, 404);
    }

    /**
     * Create monster from request params
     * 
     * @param ParameterContainer $postParams
     * @return Monster
     */
    private function createMonster(ParameterContainer $postParams)
    {
        $manager = $this->application->getManager();

        $monster = new Monster();
        $monster->setRace($postParams->get('race'))
            ->setGold($postParams->get('gold'))
            ->setLevel($postParams->get('level'))
            ->setAttack($postParams->get('attack'))
            ->setDefense($postParams->get('defense'))
            ->setTurns($postParams->get('turns'))
            ->setIsAlive($postParams->get('isAlive'));

        return $manager->insert($monster);
    }

}
