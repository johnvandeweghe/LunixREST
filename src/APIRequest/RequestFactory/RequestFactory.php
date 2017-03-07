<?php
namespace LunixREST\APIRequest\RequestFactory;

use LunixREST\APIRequest\APIRequest;
use LunixREST\APIRequest\URLParser\Exceptions\InvalidRequestURLException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * An interface to define how to convert a PSR-7 ServerRequestInterface into an APIRequest.
 * Interface RequestFactory
 * @package LunixREST\APIRequest\RequestFactory
 */
interface RequestFactory {
    /**
     * Creates a request from raw $data and a $url
     * @param ServerRequestInterface $serverRequest
     * @return APIRequest
     * @throws InvalidRequestURLException
     */
    public function create(ServerRequestInterface $serverRequest): APIRequest;
}
