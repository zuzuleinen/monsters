<?php

namespace Andrei\Controller;

use Andrei\App\Http\Response\Response;

class ApiController
{
    public function indexAction($id = null)
    {
        return new Response(sprintf('Hello id %s', $id));
    }
}

