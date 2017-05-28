<?php
namespace LunixREST\Server\Router\Endpoint\ResourceEndpoint;

use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateResourceParametersException;

/**
 * Interface ResourceParametersFactory
 * @package LunixREST\Server\Router\Endpoint\ResourceEndpoint
 */
interface ResourceParametersFactory {

    /**
     * @param APIRequest $request
     * @return ResourceParameters
     * @throws UnableToCreateResourceParametersException
     */
    public function createResourceParameters(APIRequest $request): ResourceParameters;
}
