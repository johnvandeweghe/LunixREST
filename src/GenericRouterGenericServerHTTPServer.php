<?php
namespace LunixREST;

use LunixREST\RequestFactory\RequestFactory;
use LunixREST\Server\Exceptions\UnableToHandleRequestException;
use LunixREST\Server\GenericRouterGenericServer;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnableToCreateEndpointException;
use LunixREST\Server\Router\Exceptions\MethodNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Class GenericRouterGenericServerHTTPServer
 * @package LunixREST
 */
class GenericRouterGenericServerHTTPServer extends GenericServerHTTPServer
{
    public function __construct(GenericRouterGenericServer $server, RequestFactory $requestFactory, LoggerInterface $logger)
    {
        parent::__construct($server, $requestFactory, $logger);
    }

    protected function handleServerException(UnableToHandleRequestException $exception, ResponseInterface $response): ResponseInterface
    {
        if($exception instanceof InvalidRequestException) {
            $this->logCaughtThrowableResultingInHTTPCode(400, $exception, LogLevel::INFO);
            return $response->withStatus(400, "Bad Request");

        } elseif(
            $exception instanceof ElementNotFoundException ||
            $exception instanceof UnsupportedMethodException ||
            $exception instanceof UnableToCreateEndpointException
        ) {
            $this->logCaughtThrowableResultingInHTTPCode(404, $exception, LogLevel::INFO);
            return $response->withStatus(404, "Not Found");

        } elseif($exception instanceof ElementConflictException) {
            $this->logCaughtThrowableResultingInHTTPCode(409, $exception, LogLevel::NOTICE);
            return $response->withStatus(409, "Conflict");

        } elseif(
            $exception instanceof MethodNotFoundException ||
            $exception instanceof EndpointExecutionException
        ) {
            $this->logCaughtThrowableResultingInHTTPCode(500, $exception, LogLevel::CRITICAL);
            return $response->withStatus(500, "Internal Server Error");
        }

        return parent::handleServerException($exception, $response);
    }
}
