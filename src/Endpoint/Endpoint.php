<?php
namespace LunixREST\Endpoint;

use LunixREST\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\APIRequest\APIRequest;

/**
 * Interface Endpoint
 * @package LunixREST\Endpoints
 */
interface Endpoint
{
    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function get(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function getAll(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function post(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function postAll(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function put(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function putAll(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function options(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function optionsAll(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function delete(APIRequest $request);

    /**
     * @param APIRequest $request
     * @return null|array|object
     * @throws UnsupportedMethodException
     */
    public function deleteAll(APIRequest $request);
}
