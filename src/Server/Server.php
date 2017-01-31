<?php
namespace LunixREST\Server;

use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\APIRequest\APIRequest;
use LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\APIResponse\APIResponse;
use LunixREST\Server\Exceptions\AccessDeniedException;
use LunixREST\Server\Exceptions\InvalidAPIKeyException;
use LunixREST\Server\Exceptions\MethodNotFoundException;
use LunixREST\Server\Exceptions\ThrottleLimitExceededException;

/**
 * Turns an APIRequest into an APIResponse
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
     * @throws MethodNotFoundException
     * @throws NotAcceptableResponseTypeException
     */
    public function handleRequest(APIRequest $request): APIResponse;
}
