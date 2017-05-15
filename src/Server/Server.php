<?php
namespace LunixREST\Server;

use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnknownEndpointException;
use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\APIResponse\APIResponse;
use LunixREST\Server\Exceptions\AccessDeniedException;
use LunixREST\Server\Exceptions\InvalidAPIKeyException;
use LunixREST\Server\Router\Exceptions\MethodNotFoundException;
use LunixREST\Server\Exceptions\ThrottleLimitExceededException;
use LunixREST\Server\ResponseFactory\Exceptions\NotAcceptableResponseTypeException;

/**
 * Handles an APIRequest and returns an APIResponse.
 * Interface Server
 * @package LunixREST\Server
 */
interface Server
{
    /**
     * @param APIRequest $request
     * @return APIResponse
     * @throws InvalidAPIKeyException
     * @throws AccessDeniedException
     * @throws ThrottleLimitExceededException
     * @throws UnknownEndpointException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     * @throws MethodNotFoundException
     * @throws NotAcceptableResponseTypeException
     */
    public function handleRequest(APIRequest $request): APIResponse;
}
