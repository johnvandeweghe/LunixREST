<?php
namespace LunixREST\Server;

use LunixREST\APIRequest\APIRequest;
use LunixREST\APIResponse\APIResponseData;
use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Server\Exceptions\MethodNotFoundException;

/**
 * A router is what actually determines which class a method refers to, and which method on that class
 * Interface Router
 * @package LunixREST\Server
 */
interface Router
{
    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws MethodNotFoundException
     * @throws UnknownEndpointException
     */
    public function route(APIRequest $request): APIResponseData;
}
