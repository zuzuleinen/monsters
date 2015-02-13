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
     * POST /api/monsters - create new monster
     * @return JsonResponse
     */
    public function createAction()
    {
        $monster = $this->createMonster($this->request->post);

        return new JsonResponse(MonsterResponse::getResponseObjectFromMonster($monster));
    }

    /**
     * GET /api/monsters/ - get all monsters
     * 
     * @return JsonResponse
     */
    public function getAllAction()
    {
        $manager = $this->application->getManager();

        $monsters = $manager->select(new Monster);

        if (count($monsters)) {
            /* @var $monster Monster */
            $listResponse = MonsterResponse::getResponseObjectForListOfMonsters($monsters);
            return new JsonResponse($listResponse);
        } else {
            return new JsonResponse(array(), 404);
        }
    }

    /**
     * DELETE /api/monsters - delete all monsters
     * 
     * @return JsonResponse
     */
    public function deleteAllAction()
    {
        $manager = $this->application->getManager();

        $manager->deleteAll(new Monster());
        
        return $this->getSuccessResponse();
    }

    /**
     * Get monster by id action
     * 
     * 
     * PUT /api/monsters/{id} - update monster if exists
     * POST is not allowed
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function updateById($id = null)
    {
        if ($this->request->isPost()) {
            return $this->getErrroResponse(405, ErrorResponse::MSG_METHOD_NOT_ALLOWED);
        }

        $manager = $this->application->getManager();
        $viewResponse = MonsterResponse::getEmptyResponseForMonster();

        $monster = $manager->findById(new Monster, $id);

        if ($monster instanceof Monster) {
            $monster->setRace($this->request->put->get('race'))
                ->setGold($this->request->put->get('gold'))
                ->setLevel($this->request->put->get('level'))
                ->setAttack($this->request->put->get('attack'))
                ->setDefense($this->request->put->get('defense'))
                ->setTurns($this->request->put->get('turns'))
                ->setIsAlive($this->request->put->get('isAlive'));

            $manager->update($monster);
            return new JsonResponse(MonsterResponse::getResponseObjectFromMonster($monster));
        }
        return new JsonResponse($viewResponse, 404);
    }

    /**
     * GET /api/monsters/{id} - get monster by id
     * 
     * @param string $id
     * @return JsonResponse
     */
    public function getByIdAction($id = null)
    {
        $viewResponse = MonsterResponse::getEmptyResponseForMonster();
        $manager = $this->application->getManager();

        if ($id) {
            /* @var $monster Monster */
            $monster = $manager->findById(new Monster, $id);

            if ($monster instanceof Monster) {
                $viewResponse = MonsterResponse::getResponseObjectFromMonster($monster);
                $statusCode = 200;
            } else {
                $statusCode = 404;
            }
            return new JsonResponse($viewResponse, $statusCode);
        }
        return new JsonResponse($viewResponse, 400);
    }

    /**
     * DELETE /api/monsters/{id} - delete monster by id
     * 
     * @param string $id
     * @return JsonResponse
     */
    public function deleteByIdAction($id = null)
    {
        $manager = $this->application->getManager();
        $monster = $manager->findById(new Monster, $id);

        if ($monster instanceof Monster) {
            $manager->delete($monster);
            return $this->getSuccessResponse();
        } else {
            return new JsonResponse(array(), 404);
        }
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
