<?php
namespace LunixREST\Endpoint;

use LunixREST\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\Request\Request;
use LunixREST\Response\ResponseData;

/**
 * Class Endpoint
 * @package LunixREST\Endpoints
 */
class DefaultEndpoint implements Endpoint
{
    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function get(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function getAll(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function post(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function postAll(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function put(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function putAll(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function options(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function optionsAll(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function delete(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function deleteAll(Request $request): ResponseData
    {
        throw new UnsupportedMethodException('Method not supported');
    }
}
