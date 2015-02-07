<?php

namespace Andrei\Controller;

use Andrei\App\Http\Response\Response;

class ApiController
{
    public function indexAction()
    {
        return new Response('Hello');
    }
}

