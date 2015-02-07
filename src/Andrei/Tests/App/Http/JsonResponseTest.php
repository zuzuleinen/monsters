<?php

namespace Andrei\Tests\App\Http;

use Andrei\App\Http\Response\JsonResponse;

class JsonResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     * @codeCoverageIgnore
     */
    public function testRenderIsAJsonString()
    {
        $jsonResponse = new JsonResponse(array('name' => 'Joe'));

        $this->expectOutputString('{"name":"Joe"}');

        $jsonResponse->render();
    }

    /**
     * @runInSeparateProcess
     * @codeCoverageIgnore
     */
    public function testRenderWhenContentIsStringInsteadOfArray()
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->setContent('SomeString');

        $this->expectOutputString('["SomeString"]');

        $jsonResponse->render();
    }

}
