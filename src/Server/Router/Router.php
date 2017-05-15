<?php
namespace LunixREST\Server\Router;

use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnknownEndpointException;
use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\Router\Exceptions\MethodNotFoundException;

/**
 * A router takes an APIRequest, determines an Endpoint to use, and which method to call on it, then returns the Endpoint's APIResponseData.
 * Interface Router
 * @package LunixREST\Server\Router
 */
interface Router
{
    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws MethodNotFoundException
     * @throws UnknownEndpointException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    public function route(APIRequest $request): APIResponseData;
}
