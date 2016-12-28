<?php
namespace LunixREST\Server;

use LunixREST\APIRequest\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidAPIKeyException;
use LunixREST\Exceptions\ThrottleLimitExceededException;
use LunixREST\Server\Exceptions\MethodNotFoundException;

class HTTPServerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandleRequestReturns400WhenCreateThrowsInvalidURLException()
    {
        $expectedStatusCode = 400;
        $expectedStatusMessage = '400 Bad Request';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedSever = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create')->willThrowException(new InvalidRequestURLException());

        $httpServer = new HTTPServer($mockedSever, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns500WhenCreateThrowsUnknownException()
    {
        $expectedStatusCode = 500;
        $expectedStatusMessage = '500 Internal Server Error';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedSever = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create')->willThrowException(new \Exception());

        $httpServer = new HTTPServer($mockedSever, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns400WhenHandleRequestThrowsInvalidAPIKeyException()
    {
        $expectedStatusCode = 400;
        $expectedStatusMessage = '400 Bad Request';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willThrowException(new InvalidAPIKeyException());

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns404WhenHandleRequestThrowsUnknownEndpointException()
    {
        $expectedStatusCode = 404;
        $expectedStatusMessage = '404 Not Found';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willThrowException(new UnknownEndpointException());

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns406WhenHandleRequestThrowsNotAcceptableResponseTypeException()
    {
        $expectedStatusCode = 406;
        $expectedStatusMessage = '406 Not Acceptable';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willThrowException(new NotAcceptableResponseTypeException());

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns403WhenHandleRequestThrowsAccessDeniedException()
    {
        $expectedStatusCode = 403;
        $expectedStatusMessage = '403 Access Denied';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willThrowException(new AccessDeniedException());

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns429WhenHandleRequestThrowsThrottleLimitExceededException()
    {
        $expectedStatusCode = 429;
        $expectedStatusMessage = '429 Too Many Requests';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willThrowException(new ThrottleLimitExceededException());

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns500WhenHandleRequestThrowsMethodNotFoundException()
    {
        $expectedStatusCode = 500;
        $expectedStatusMessage = '500 Internal Server Error';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willThrowException(new MethodNotFoundException());

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns500WhenHandleRequestThrowsException()
    {
        $expectedStatusCode = 500;
        $expectedStatusMessage = '500 Internal Server Error';

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willThrowException(new \Exception());

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testHandleRequestReturns200WithMIMESizeAndData()
    {
        $expectedStatusCode = 200;
        $expectedStatusMessage = '200 OK';
        $expectedMIMEType = 'application/json';
        $expectedResponseSize = 541984;

        $mockedDataStream = $this->getMockBuilder('\Psr\Http\Message\StreamInterface')->getMock();
        $mockedDataStream->method('getSize')->willReturn($expectedResponseSize);

        $contentTypeORContentLength = $this->logicalOr($this->equalTo("Content-Type"), $this->equalTo("Content-Length"));
        $mimeTypeORResponseSize = $this->logicalOr($this->equalTo($expectedMIMEType), $this->equalTo($expectedResponseSize));
        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);
        $mockedResponse->expects($this->exactly(2))->method('withAddedHeader')
            ->with($contentTypeORContentLength, $mimeTypeORResponseSize)->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withBody')->with($mockedDataStream)->willReturn($mockedResponse);

        $mockedAPIResponse = $this->getMockBuilder('\LunixREST\APIResponse\APIResponse')->getMock();
        $mockedAPIResponse->method('getMIMEType')->willReturn($expectedMIMEType);
        $mockedAPIResponse->method('getAsDataStream')->willReturn($mockedDataStream);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willReturn($mockedAPIResponse);

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\APIRequest\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory);

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }
}
