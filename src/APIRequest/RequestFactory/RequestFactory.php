<?php
namespace LunixREST\APIRequest\RequestFactory;

use LunixREST\APIRequest\APIRequest;
use LunixREST\APIRequest\URLParser\Exceptions\InvalidRequestURLException;
use Psr\Http\Message\ServerRequestInterface;

interface RequestFactory {
    /**
     * Creates a request from raw $data and a $url
     * @param ServerRequestInterface $serverRequest
     * @return APIRequest
     * @throws InvalidRequestURLException
     */
    public function create(ServerRequestInterface $serverRequest): APIRequest;
}
