<?php
namespace LunixREST\Server;

use LunixREST\APIRequest\APIRequest;
use LunixREST\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Server\Exceptions\AccessDeniedException;
use LunixREST\Server\Exceptions\InvalidAPIKeyException;
use LunixREST\APIRequest\RequestFactory\RequestFactory;
use LunixREST\APIRequest\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Server\Exceptions\MethodNotFoundException;
use LunixREST\Server\Exceptions\ThrottleLimitExceededException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * A class that interfaces PSR-7 with our APIRequests and uses a Server to handle the APIRequest. Handles the PSR-7 response building as well.
 * Class HTTPServer
 * @package LunixREST\Server
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
    private $requestFactory;

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
            $APIRequest = $this->requestFactory->create($serverRequest);

            return $this->handleAPIRequest($APIRequest, $response);
        } catch (InvalidRequestURLException $e) {
            $this->logCaughtThrowableResultingInHTTPCode(400, $e, LogLevel::INFO);
            return $response->withStatus(400, "Bad Request");
        } catch (\Throwable $e) {
            $this->logCaughtThrowableResultingInHTTPCode(500, $e, LogLevel::CRITICAL);
            return $response->withStatus(500, "Internal Server Error");
        }
    }

    /**
     * Takes an APIRequest and a ResponseInterface and creates a new ResponseInterface derived from the passed implementation and returns it.
     * @param APIRequest $APIRequest
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function handleAPIRequest(APIRequest $APIRequest, ResponseInterface $response)
    {
        try {
            $APIResponse = $this->server->handleRequest($APIRequest);

            $response = $response->withStatus(200, "200 OK");
            $response = $response->withAddedHeader("Content-Type", $APIResponse->getMIMEType());
            $response = $response->withAddedHeader("Content-Length", $APIResponse->getAsDataStream()->getSize());
            $this->logger->debug("Responding to request successfully");
            return $response->withBody($APIResponse->getAsDataStream());
        } catch (InvalidRequestException $e) {
            $this->logCaughtThrowableResultingInHTTPCode(400, $e, LogLevel::INFO);
            return $response->withStatus(400, "Bad Request");
        } catch (UnknownEndpointException | ElementNotFoundException $e) {
            $this->logCaughtThrowableResultingInHTTPCode(404, $e, LogLevel::INFO);
            return $response->withStatus(404, "Not Found");
        } catch (NotAcceptableResponseTypeException $e) {
            $this->logCaughtThrowableResultingInHTTPCode(406, $e, LogLevel::INFO);
            return $response->withStatus(406, "Not Acceptable");
        } catch (InvalidAPIKeyException | AccessDeniedException $e) {
            $this->logCaughtThrowableResultingInHTTPCode(403, $e, LogLevel::NOTICE);
            return $response->withStatus(403, "Access Denied");
        }  catch (ElementConflictException $e) {
            $this->logCaughtThrowableResultingInHTTPCode(409, $e, LogLevel::NOTICE);
            return $response->withStatus(409, "Conflict");
        } catch (ThrottleLimitExceededException $e) {
            $this->logCaughtThrowableResultingInHTTPCode(429, $e, LogLevel::WARNING);
            return $response->withStatus(429, "Too Many Requests");
        } catch (MethodNotFoundException | \Throwable $e) {
            $this->logCaughtThrowableResultingInHTTPCode(500, $e, LogLevel::CRITICAL);
            return $response->withStatus(500, "Internal Server Error");
        }
    }

    /**
     * Dumps a PSR-7 ResponseInterface to the SAPI.
     * @param ResponseInterface $response
     */
    public static function dumpResponse(ResponseInterface $response) {
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

    protected function logCaughtThrowableResultingInHTTPCode(int $code, \Throwable $exception, $level): void
    {
        $this->logger->log($level, "Returning HTTP {code}: {message}", ["code" => $code, "message" => $exception->getMessage()]);
    }
}
