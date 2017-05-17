<?php
namespace LunixREST\Server\Router\Endpoint;

use LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException;
use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\APIResponse\APIResponseData;

/**
 * An interface that defines different request types as methods, and returns APIResponse Data.
 * This is the primary interface that user code for an API will be implementing.
 * Interface Endpoint
 * @package LunixREST\Server\Router\Endpoint
 */
interface Endpoint
{
    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function get(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function getAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function post(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function postAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function put(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function putAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function patch(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function patchAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function options(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function optionsAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function delete(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     */
    public function deleteAll(APIRequest $request): APIResponseData;
}
