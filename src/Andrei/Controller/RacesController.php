<?php

namespace Andrei\Controller;

use Andrei\App\Http\JsonResponse;
use Andrei\App\Http\Response;

class RacesController
{
    public function indexAction()
    {
        return new JsonResponse(array('name' => 'zuzu'));
    }

    public function testareAction()
    {
        return new Response('this is a simple string.');
    }

}
