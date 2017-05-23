<?php
namespace LunixREST;

use LunixREST\RequestFactory\Exceptions\UnableToCreateRequestException;
use LunixREST\Server\APIResponse\APIResponse;
use LunixREST\Server\Exceptions\UnableToHandleRequestException;
use LunixREST\RequestFactory\RequestFactory;
use LunixREST\Server\Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * A class that interfaces PSR-7 with our APIRequests and uses a Server to handle the APIRequest. Handles the PSR-7 response building as well.
 * Class HTTPServer
 * @package LunixREST
 */
class HTTPServer
{
    use LoggerAwareTrait;

    /**
     * @var Server
     */
    protected $server;
    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * HTTPServer constructor.
     * @param Server $server
     * @param RequestFactory $requestFactory
     * @param LoggerInterface $logger
     */
    public function __construct(Server $server, RequestFactory $requestFactory, LoggerInterface $logger)
    {
        $this->server = $server;
        $this->requestFactory = $requestFactory;
        $this->logger = $logger;
    }

    /**
     * Clones a response, changing contents based on the handling of a given request.
     * Taking in a response allows us not to define a specific response implementation to create.
     * @param ServerRequestInterface $serverRequest
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function handleRequest(ServerRequestInterface $serverRequest, ResponseInterface $response): ResponseInterface
    {
        $response = $response->withProtocolVersion($serverRequest->getProtocolVersion());

        try {
            try {
                $APIRequest = $this->requestFactory->create($serverRequest);
            } catch (UnableToCreateRequestException $exception) {
                return $this->handleRequestFactoryException($exception, $response);
            }

            try {
                $APIResponse = $this->server->handleRequest($APIRequest);
            } catch (UnableToHandleRequestException $exception) {
                return $this->handleServerException($exception, $response);
            }

            return $this->buildResponse($APIResponse, $response);
        } catch (\Throwable $e) {
            $this->logCaughtThrowableResultingInHTTPCode(500, $e, LogLevel::CRITICAL);
            return $response->withStatus(500, "Internal Server Error");
        }
    }

    /**
     * Takes an APIResponse and builds a PSR-7 Response
     * @param APIResponse $APIResponse
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function buildResponse(APIResponse $APIResponse, ResponseInterface $response): ResponseInterface
    {
        $response = $response->withStatus(200, "200 OK");
        $response = $response->withAddedHeader("Content-Type", $APIResponse->getMIMEType());
        $response = $response->withAddedHeader("Content-Length", $APIResponse->getAsDataStream()->getSize());
        $this->logger->debug("Responding to request successfully");
        return $response->withBody($APIResponse->getAsDataStream());
    }

    /**
     * @param UnableToCreateRequestException $exception
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function handleRequestFactoryException(UnableToCreateRequestException $exception, ResponseInterface $response): ResponseInterface
    {
        $this->logCaughtThrowableResultingInHTTPCode(400, $exception, LogLevel::INFO);
        return $response->withStatus(400, "Bad Request");
    }

    /**
     * @param UnableToHandleRequestException $exception
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function handleServerException(UnableToHandleRequestException $exception, ResponseInterface $response): ResponseInterface
    {
        $this->logCaughtThrowableResultingInHTTPCode(500, $exception, LogLevel::CRITICAL);
        return $response->withStatus(500, "Internal Server Error");
    }

    /**
     * Dumps a PSR-7 ResponseInterface to the SAPI.
     * @param ResponseInterface $response
     */
    public static function dumpResponse(ResponseInterface $response)
    {
        $statusLine = sprintf(
            "HTTP/%s %d %s",
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        header($statusLine, true, $response->getStatusCode());

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }

        $body = $response->getBody();
        while(!$body->eof()) {
            echo $body->read(1024);
        }
    }

    /**
     * @param int $code
     * @param \Throwable $exception
     * @param $level
     */
    protected function logCaughtThrowableResultingInHTTPCode(int $code, \Throwable $exception, $level): void
    {
        $this->logger->log($level, "Returning HTTP {code}: {message}", ["code" => $code, "message" => $exception->getMessage()]);
    }
}
