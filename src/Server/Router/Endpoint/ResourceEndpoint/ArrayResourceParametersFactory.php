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
     * @throws UnableToCreateResourceParametersException
     */
    public function createResourceParameters(APIRequest $request): ResourceParameters
    {
        $requestData = $request->getData() ?? [];
        $requestElement = $request->getElement();

        self::checkRequestDataIsArray($requestData);

        $data = array_merge($request->getQueryData(), $requestData);

        return $this->createResourceParametersFromArray($requestElement, $data);
    }

    /**
     * @param APIRequest $request
     * @return ResourceParameters[]
     * @throws UnableToCreateResourceParametersException
     */
    public function createMultipleResourceParameters(APIRequest $request): array
    {
        $requestData = $request->getData() ?? [];
        $requestElement = $request->getElement();

        self::checkRequestDataIsArray($requestData);

        $queryData = $request->getQueryData();

        return array_map(function($data) use ($queryData, $requestElement) {
            $data = array_merge($queryData, $data);
            return $this->createResourceParametersFromArray($requestElement, $data);
        }, $requestData);
    }

    /**
     * @param array|object|null $requestData
     * @throws UnableToCreateResourceParametersException
     */
    private static function checkRequestDataIsArray($requestData): void
    {
        if(!is_array($requestData)) {
            throw new UnableToCreateResourceParametersException("Unable to read request as array or null");
        }
    }

    /**
     * @param string $element
     * @param array $data
     * @return ResourceParameters
     */
    abstract protected function createResourceParametersFromArray($element, array $data): ResourceParameters;

}
