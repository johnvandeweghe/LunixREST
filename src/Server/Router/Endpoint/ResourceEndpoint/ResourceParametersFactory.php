<?php
namespace LunixREST\Server\Router\Endpoint\ResourceEndpoint;

use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateResourceParametersException;

/**
 * interface ResourceParametersFactory
 * @package LunixREST\Server\Router\Endpoint\ResourceEndpoint
 */
interface ResourceParametersFactory
{
    /**
     * @param APIRequest $request
     * @return ResourceParameters
     * @throws UnableToCreateResourceParametersException
     */
    public function createResourceParameters(APIRequest $request): ResourceParameters;

    /**
     * Reads a request and parses out plural ResourceParameters. Used when patching all for example.
     *
     * @param APIRequest $request
     * @return ResourceParameters[]
     * @throws UnableToCreateResourceParametersException
     */
    public function createMultipleResourceParameters(APIRequest $request): array;
}
