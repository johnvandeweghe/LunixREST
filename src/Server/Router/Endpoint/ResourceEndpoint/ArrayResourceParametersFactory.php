<?php
namespace LunixREST\Server\Router\Endpoint\ResourceEndpoint;

use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateResourceParametersException;

/**
 * An implementation of a ResourceParametersFactory that assumes that the request data is an associative array. Joins url parameters with body.
 * Class ArrayResourceParametersFactory
 * @package LunixREST\Server\Router\Endpoint\ResourceEndpoint
 */
abstract class ArrayResourceParametersFactory implements ResourceParametersFactory
{
    /**
     * @param APIRequest $request
     * @return ResourceParameters
     */
    public function createResourceParameters(APIRequest $request): ResourceParameters
    {
        self::checkRequestDataIsArray($request);

        $data = array_merge($request->getQueryData(), $request->getData());

        return $this->createResourceParametersFromArray($data);
    }

    /**
     * @param APIRequest $request
     * @return ResourceParameters[]
     */
    public function createMultipleResourceParameters(APIRequest $request): array
    {
        self::checkRequestDataIsArray($request);

        $queryData = $request->getQueryData();

        return array_map(function($data) use ($queryData) {
            $data = array_merge($queryData, $data);
            return $this->createResourceParametersFromArray($data);
        }, $request->getData());
    }

    /**
     * @param APIRequest $request
     * @throws UnableToCreateResourceParametersException
     */
    private static function checkRequestDataIsArray(APIRequest $request): void
    {
        if(!is_array($request->getData())) {
            throw new UnableToCreateResourceParametersException("Unable to read request as array");
        }
    }

    /**
     * @param array $data
     * @return ResourceParameters
     */
    abstract protected function createResourceParametersFromArray(array $data): ResourceParameters;

}
