<?php
namespace LunixREST\Server;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * An HTTP server implementation that assumes the server request contains a json body
 * Class JSONHTTPServer
 * @package LunixREST\Server
 */
class JSONHTTPServer extends HTTPServer
{
    /**
     * @param ServerRequestInterface $serverRequest
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function handleRequest(ServerRequestInterface $serverRequest, ResponseInterface $response): ResponseInterface
    {
        $serverRequest = self::parseBodyAsJSON($serverRequest);
        return parent::handleRequest($serverRequest, $response);
    }

    /**
     * @param ServerRequestInterface $serverRequest
     * @return ServerRequestInterface
     */
    public static function parseBodyAsJSON(ServerRequestInterface $serverRequest): ServerRequestInterface
    {
        //Use toString so that we don't have to rewind it
        $jsonBody = json_decode($serverRequest->getBody()->__toString(), true);
        return $serverRequest->withParsedBody($jsonBody);
    }
}
