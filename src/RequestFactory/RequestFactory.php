<?php
namespace LunixREST\RequestFactory;

use LunixREST\RequestFactory\Exceptions\UnableToCreateRequestException;
use LunixREST\Server\APIRequest\APIRequest;
use Psr\Http\Message\ServerRequestInterface;

/**
 * An interface to define how to convert a PSR-7 ServerRequestInterface into an APIRequest.
 * Interface RequestFactory
 * @package LunixREST\RequestFactory
 */
interface RequestFactory {
    /**
     * Creates a request from raw $data and a $url
     * @param ServerRequestInterface $serverRequest
     * @return APIRequest
     * @throws UnableToCreateRequestException
     */
    public function create(ServerRequestInterface $serverRequest): APIRequest;
}
