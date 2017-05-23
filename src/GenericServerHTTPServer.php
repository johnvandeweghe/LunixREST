<?php
namespace LunixREST;

use LunixREST\RequestFactory\RequestFactory;
use LunixREST\Server\Exceptions\AccessDeniedException;
use LunixREST\Server\Exceptions\InvalidAPIKeyException;
use LunixREST\Server\Exceptions\ThrottleLimitExceededException;
use LunixREST\Server\Exceptions\UnableToHandleRequestException;
use LunixREST\Server\GenericServer;
use LunixREST\Server\ResponseFactory\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Server\ResponseFactory\Exceptions\UnableToCreateAPIResponseException;
use LunixREST\Server\Router\Exceptions\UnableToRouteRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * An HTTPServer that requires that the passed Server is a GenericServer
 * Class GenericServerHTTPServer
 * @package LunixREST
 */
class GenericServerHTTPServer extends HTTPServer
{
    /**
     * GenericServerHTTPServer constructor.
     * @param GenericServer $server
     * @param RequestFactory $requestFactory
     * @param LoggerInterface $logger
     */
    public function __construct(GenericServer $server, RequestFactory $requestFactory, LoggerInterface $logger)
    {
        parent::__construct($server, $requestFactory, $logger);
    }

    /**
     * @param UnableToHandleRequestException $exception
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function handleServerException(UnableToHandleRequestException $exception, ResponseInterface $response): ResponseInterface
    {
        if($exception instanceof InvalidAPIKeyException || $exception instanceof AccessDeniedException) {
            $this->logCaughtThrowableResultingInHTTPCode(403, $exception, LogLevel::NOTICE);
            return $response->withStatus(403, "Access Denied");

        } elseif($exception instanceof ThrottleLimitExceededException) {
            $this->logCaughtThrowableResultingInHTTPCode(429, $exception, LogLevel::WARNING);
            return $response->withStatus(429, "Too Many Requests");

        } elseif($exception instanceof NotAcceptableResponseTypeException) {
            $this->logCaughtThrowableResultingInHTTPCode(406, $exception, LogLevel::INFO);
            return $response->withStatus(406, "Not Acceptable");

        } elseif(
            $exception instanceof UnableToCreateAPIResponseException ||
            $exception instanceof UnableToRouteRequestException
        ) {
            $this->logCaughtThrowableResultingInHTTPCode(500, $exception, LogLevel::CRITICAL);
            return $response->withStatus(500, "Internal Server Error");
        }

        return parent::handleServerException($exception, $response);
    }
}

