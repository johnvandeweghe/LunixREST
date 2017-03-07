<?php
namespace LunixREST\Server;

use LunixREST\APIRequest\APIRequest;
use LunixREST\APIResponse\APIResponseData;
use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Server\Exceptions\MethodNotFoundException;

/**
 * A router takes an APIRequest, determines an Endpoint to use, and which method to call on it, then returns the Endpoint's APIResponseData.
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
