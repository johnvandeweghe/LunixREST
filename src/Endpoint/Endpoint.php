<?php
namespace LunixREST\Endpoint;

use LunixREST\APIResponse\APIResponseData;
use LunixREST\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\APIRequest\APIRequest;

/**
 * An interface that defines different request types as methods, and returns APIResponse Data.
 * This is the primary interface that user code for an API will be implementing.
 * Interface Endpoint
 * @package LunixREST\Endpoints
 */
interface Endpoint
{
    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function get(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function getAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function post(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function postAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function put(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function putAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function options(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function optionsAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function delete(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     */
    public function deleteAll(APIRequest $request): APIResponseData;
}
