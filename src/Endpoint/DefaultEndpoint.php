<?php
namespace LunixREST\Endpoint;

use LunixREST\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\APIRequest\APIRequest;
use LunixREST\APIResponse\ResponseData;

/**
 * Class Endpoint
 * @package LunixREST\Endpoints
 */
class DefaultEndpoint implements Endpoint
{
    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function get(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function getAll(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function post(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function postAll(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function put(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function putAll(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function options(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function optionsAll(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function delete(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function deleteAll(APIRequest $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }
}
