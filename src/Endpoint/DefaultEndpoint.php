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
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function get(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function getAll(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function post(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function postAll(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function put(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function putAll(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function options(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function optionsAll(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function delete(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function deleteAll(APIRequest $request)
    {
        throw new UnsupportedMethodException('Method not supported');
    }
}
