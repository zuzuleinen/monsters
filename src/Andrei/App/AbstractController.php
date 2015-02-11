<?php

namespace Andrei\App;

use Andrei\App\Application;
use Andrei\App\Http\Request;
use Andrei\Game\Response\SuccessResponse;
use Andrei\App\Http\Response\JsonResponse;
use Andrei\Game\Response\ErrorResponse;

/**
 * Abstract controller class. Extend this for 
 * each new controller you create
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class AbstractController
{

    /**
     * @var Application 
     */
    protected $application;

    /**
     * @var Request 
     */
    protected $request;

    /**
     * Set application
     * 
     * @param Application $application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Set request object
     * 
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get a generic success response
     * 
     * @return JsonResponse
     */
    public function getSuccessResponse()
    {
        $content = SuccessResponse::getContent();

        return new JsonResponse($content);
    }

    /**
     * Get error response
     * 
     * @param int $code HTTP status code
     * @param string $message
     * @return JsonResponse
     */
    public function getErrroResponse($code, $message = null)
    {
        $errorResponse = new ErrorResponse($message);

        $content = $errorResponse->getContent();

        return new JsonResponse($content, $code);
    }
    
    /**
     * Generic method for method not allowed response
     * 
     * @return JsonResponse
     */
    public function methodNotAllowedAction()
    {
        return $this->getErrroResponse(405, ErrorResponse::MSG_METHOD_NOT_ALLOWED);
    }

}
