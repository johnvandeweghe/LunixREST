<?php
namespace LunixREST\Server\Router;

use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\Router\Exceptions\UnableToRouteRequestException;

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
     * @throws UnableToRouteRequestException
     */
    public function route(APIRequest $request): APIResponseData;
}
