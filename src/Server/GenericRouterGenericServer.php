<?php
namespace LunixREST\Server;

use LunixREST\Server\AccessControl\AccessControl;
use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\APIResponse\APIResponse;
use LunixREST\Server\Exceptions\UnableToHandleRequestException;
use LunixREST\Server\ResponseFactory\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Server\ResponseFactory\Exceptions\UnableToCreateAPIResponseException;
use LunixREST\Server\ResponseFactory\ResponseFactory;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnableToCreateEndpointException;
use LunixREST\Server\Router\Exceptions\MethodNotFoundException;
use LunixREST\Server\Router\Exceptions\UnableToRouteRequestException;
use LunixREST\Server\Router\GenericRouter;
use LunixREST\Server\Throttle\Throttle;
use LunixREST\Server\Exceptions\AccessDeniedException;
use LunixREST\Server\Exceptions\InvalidAPIKeyException;
use LunixREST\Server\Exceptions\ThrottleLimitExceededException;

/**
 * A GenericServer that requires a GenericRouter to be used as it's router. Helpful to define exceptions to handle with this
 * combination.
 * Class GenericRouterGenericServer
 * @package LunixREST\Server
 */
class GenericRouterGenericServer extends GenericServer
{
    /**
     * GenericRouterGenericServer constructor.
     * @param AccessControl $accessControl
     * @param Throttle $throttle
     * @param ResponseFactory $responseFactory
     * @param GenericRouter $router
     */
    public function __construct(
        AccessControl $accessControl,
        Throttle $throttle,
        ResponseFactory $responseFactory,
        GenericRouter $router
    ) {
        parent::__construct($accessControl, $throttle, $responseFactory, $router);
    }


    /**
     * @param APIRequest $request
     * @return APIResponse
     * @throws UnableToHandleRequestException
     * @throws InvalidAPIKeyException
     * @throws ThrottleLimitExceededException
     * @throws NotAcceptableResponseTypeException
     * @throws AccessDeniedException
     * @throws UnableToRouteRequestException
     * @throws UnableToCreateEndpointException
     * @throws MethodNotFoundException
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     * @throws UnableToCreateAPIResponseException
     */
    public function handleRequest(APIRequest $request): APIResponse
    {
        return parent::handleRequest($request);
    }
}
