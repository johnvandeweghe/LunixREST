<?php
namespace LunixREST\Server;

use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidAPIKeyException;
use LunixREST\Exceptions\ThrottleLimitExceededException;
use LunixREST\APIRequest\RequestFactory\RequestFactory;
use LunixREST\APIRequest\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Server\Exceptions\MethodNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HTTPServer
{
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
     */
    //TODO: Add RequestLogger that we can pass through to log requests
    //TODO: Add ErrorLogger to log errors (500s)
    public function __construct(Server $server, RequestFactory $requestFactory)
    {
        $this->server = $server;
        $this->requestFactory = $requestFactory;
    }

    /**
     * clones a response, changing contents based on the handling of a given request
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

            try {
                $APIResponse = $this->server->handleRequest($APIRequest);

                $response = $response->withStatus(200, "200 OK");
                $response = $response->withAddedHeader("Content-Type", $APIResponse->getMIMEType());
                $response = $response->withAddedHeader("Content-Length", $APIResponse->getAsDataStream()->getSize());
                return $response->withBody($APIResponse->getAsDataStream());
            } catch (InvalidAPIKeyException $e) {
                return $response->withStatus(400, "400 Bad Request");
            } catch (UnknownEndpointException $e) {
                return $response->withStatus(404, "404 Not Found");
            } catch (NotAcceptableResponseTypeException $e) {
                return $response->withStatus(406, "406 Not Acceptable");
            } catch (AccessDeniedException $e) {
                return $response->withStatus(403, "403 Access Denied");
            } catch (ThrottleLimitExceededException $e) {
                return $response->withStatus(429, "429 Too Many Requests");
            } catch (MethodNotFoundException | \Throwable $e) {
                return $response->withStatus(500, "500 Internal Server Error");
            }
        } catch (InvalidRequestURLException $e) {
            return $response->withStatus(400, "400 Bad Request");
        } catch (\Throwable $e) {
            return $response->withStatus(500, "500 Internal Server Error");
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
