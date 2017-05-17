<?php
namespace LunixREST\Server;

use LunixREST\Server\Exceptions\UnableToHandleRequestException;
use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\APIResponse\APIResponse;

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
     * @throws UnableToHandleRequestException
     */
    public function handleRequest(APIRequest $request): APIResponse;
}
