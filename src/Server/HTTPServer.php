<?php
namespace LunixREST\Server;

use LunixREST\APIRequest\APIRequest;
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
     * Clones a response, changing contents based on the handling of a given request
     * Taking in a response allows us not to define a specific response implementation to create
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
            $this->logger->notice($e->getMessage());
            return $response->withStatus(400, "Bad Request");
        } catch (\Throwable $e) {
            $this->logger->critical($e->getMessage());
            return $response->withStatus(500, "Internal Server Error");
        }
    }

    protected function handleAPIRequest(APIRequest $APIRequest, ResponseInterface $response)
    {
        try {
            $APIResponse = $this->server->handleRequest($APIRequest);

            $response = $response->withStatus(200, "200 OK");
            $response = $response->withAddedHeader("Content-Type", $APIResponse->getMIMEType());
            $response = $response->withAddedHeader("Content-Length", $APIResponse->getAsDataStream()->getSize());
            $this->logger->debug("Responding to request successfully");
            return $response->withBody($APIResponse->getAsDataStream());
        } catch (InvalidAPIKeyException $e) {
            $this->logger->notice($e->getMessage());
            return $response->withStatus(400, "Bad Request");
        } catch (UnknownEndpointException $e) {
            $this->logger->notice($e->getMessage());
            return $response->withStatus(404, "Not Found");
        } catch (NotAcceptableResponseTypeException $e) {
            $this->logger->notice($e->getMessage());
            return $response->withStatus(406, "Not Acceptable");
        } catch (AccessDeniedException $e) {
            $this->logger->notice($e->getMessage());
            return $response->withStatus(403, "Access Denied");
        } catch (ThrottleLimitExceededException $e) {
            $this->logger->warning($e->getMessage());
            return $response->withStatus(429, "Too Many Requests");
        } catch (MethodNotFoundException | \Throwable $e) {
            $this->logger->critical($e->getMessage());
            return $response->withStatus(500, "Internal Server Error");
        }
    }

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
}
