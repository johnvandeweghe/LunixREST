<?php
namespace LunixREST\Server\Router\Endpoint\ResourceEndpoint;

use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateAPIResponseDataException;

/**
 * Interface ResourceAPIResponseDataFactory
 * @package LunixREST\Server\Router\Endpoint\ResourceEndpoint
 */
interface ResourceAPIResponseDataFactory {

    /**
     * @param Resource $resource
     * @return APIResponseData
     * @throws UnableToCreateAPIResponseDataException
     */
    public function toAPIResponseData(Resource $resource): APIResponseData;
}
