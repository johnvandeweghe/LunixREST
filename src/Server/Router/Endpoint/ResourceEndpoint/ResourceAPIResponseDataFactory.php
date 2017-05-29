<?php
namespace LunixREST\Server\Router\Endpoint\ResourceEndpoint;

use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateAPIResponseDataException;

/**
 * abstract class ResourceAPIResponseDataFactory
 * @package LunixREST\Server\Router\Endpoint\ResourceEndpoint
 */
abstract class ResourceAPIResponseDataFactory {

    /**
     * @param null|Resource $resource
     * @return APIResponseData
     * @throws UnableToCreateAPIResponseDataException
     */
    abstract public function toAPIResponseData(?Resource $resource): APIResponseData;

    /**
     * Uses above method for each resource, extracting the data into an array, creating a new APIResponseData from that array.
     * @param null|Resource[] $resources
     * @return APIResponseData
     * @throws UnableToCreateAPIResponseDataException
     */
    public function multipleToAPIResponseData(?array $resources): APIResponseData
    {
        if(is_null($resources)) {
            return $this->toAPIResponseData(null);
        }

        return new APIResponseData(array_map(function(Resource $resource) {
            return $this->toAPIResponseData($resource)->getData();
        }, $resources));
    }
}
