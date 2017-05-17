<?php
namespace LunixREST\Server\Router\Endpoint;

use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\APIResponse\APIResponseData;

/**
 * An Endpoint that throws UnsupportedMethodException for all requests.
 * Class Endpoint
 * @package LunixREST\Server\Router\Endpoint
 */
class DefaultEndpoint implements Endpoint
{
    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function get(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function getAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    public function post(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    public function postAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    public function put(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    public function putAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    public function patch(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    public function patchAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function options(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function optionsAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function delete(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function deleteAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }
}
