<?php
namespace LunixREST\Endpoint;

use LunixREST\APIResponse\APIResponseData;
use LunixREST\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\APIRequest\APIRequest;

/**
 * An Endpoint that throws UnsupportedMethodException for all requests.
 * Class Endpoint
 * @package LunixREST\Endpoints
 */
class DefaultEndpoint implements Endpoint
{
    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     */
    public function get(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function getAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     */
    public function post(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function postAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     */
    public function put(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function putAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     */
    public function patch(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function patchAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     */
    public function options(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function optionsAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     */
    public function delete(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function deleteAll(APIRequest $request): APIResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }
}
