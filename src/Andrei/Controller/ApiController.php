<?php

namespace Andrei\Controller;

use Andrei\App\AbstractController;

use Andrei\App\Http\Response\Response;

class ApiController extends AbstractController
{
    public function indexAction($id = null)
    {
        return new Response(sprintf('Hello id %s', $id));
    }
}

