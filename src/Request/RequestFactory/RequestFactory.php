<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\Request;
use LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException;

interface RequestFactory {
    /**
     * Creates a request from raw $data and a $url
     * @param $method
     * @param array $headers
     * @param $data
     * @param $ip
     * @param $url
     * @return Request
     * @throws InvalidRequestURLException
     */
    public function create($method, array $headers, string $data, $ip, $url): Request;
}
