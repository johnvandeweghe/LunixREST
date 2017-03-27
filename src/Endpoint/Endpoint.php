<?php
namespace LunixREST\Endpoint;

use LunixREST\APIResponse\APIResponseData;
use LunixREST\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Endpoint\Exceptions\InvalidRequestException;
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
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function get(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function getAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function post(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function postAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function put(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function putAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function patch(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function patchAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function options(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function optionsAll(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    public function delete(APIRequest $request): APIResponseData;

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    public function deleteAll(APIRequest $request): APIResponseData;
}
