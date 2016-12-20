<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\BodyParser\Exceptions\InvalidRequestDataException;
use LunixREST\Request\BodyParser\Exceptions\UnknownContentTypeException;
use LunixREST\Request\Request;
use LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException;

interface RequestFactory
{
    /**
     * Creates a request from raw $data and a $url
     * @param $method
     * @param array $headers
     * @param $data
     * @param $ip
     * @param $url
     * @return Request
     * @throws InvalidRequestURLException
     * @throws UnknownContentTypeException
     * @throws InvalidRequestDataException
     */
    public function create($method, array $headers, string $data, $ip, $url): Request;
}
