<?php
namespace LunixREST;

use LunixREST\RequestFactory\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnknownEndpointException;
use LunixREST\Server\Exceptions\AccessDeniedException;
use LunixREST\Server\Exceptions\InvalidAPIKeyException;
use LunixREST\Server\Exceptions\ThrottleLimitExceededException;
use LunixREST\Server\Router\Exceptions\MethodNotFoundException;
use LunixREST\Server\ResponseFactory\Exceptions\NotAcceptableResponseTypeException;
use Psr\Log\NullLogger;

//Mock the header function, storing results in a public static on the test object (cleared on tearDown)
function header($string, $replace = true, $http_response_code = null) {
    HTTPServerTest::$headerCalls[] = [$string, $replace, $http_response_code];
}


class HTTPServerTest extends \PHPUnit\Framework\TestCase
{
    public static $headerCalls = [];

    public function tearDown()
    {
        self::$headerCalls = [];
    }

    public function testHandleRequestReturns400WhenCreateThrowsInvalidURLException()
    {
        $exception = new InvalidRequestURLException();
        $expectedStatusCode = 400;
        $expectedStatusMessage = 'Bad Request';

        $this->assertCreateWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns500WhenCreateThrowsUnknownException()
    {
        $exception = new \Exception();
        $expectedStatusCode = 500;
        $expectedStatusMessage = 'Internal Server Error';

        $this->assertCreateWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns400WhenHandleRequestThrowsInvalidAPIKeyException()
    {
        $exception = new InvalidAPIKeyException();
        $expectedStatusCode = 403;
        $expectedStatusMessage = 'Access Denied';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns400WhenHandleRequestThrowsInvalidRequestException()
    {
        $exception = new InvalidRequestException();
        $expectedStatusCode = 400;
        $expectedStatusMessage = 'Bad Request';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns404WhenHandleRequestThrowsUnknownEndpointException()
    {
        $exception = new UnknownEndpointException();
        $expectedStatusCode = 404;
        $expectedStatusMessage = 'Not Found';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns404WhenHandleRequestThrowsElementNotFoundException()
    {
        $exception = new ElementNotFoundException();
        $expectedStatusCode = 404;
        $expectedStatusMessage = 'Not Found';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns406WhenHandleRequestThrowsNotAcceptableResponseTypeException()
    {
        $exception = new NotAcceptableResponseTypeException();
        $expectedStatusCode = 406;
        $expectedStatusMessage = 'Not Acceptable';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns403WhenHandleRequestThrowsAccessDeniedException()
    {
        $exception = new AccessDeniedException();
        $expectedStatusCode = 403;
        $expectedStatusMessage = 'Access Denied';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns409WhenHandleRequestThrowsElementConflictException()
    {
        $exception = new ElementConflictException();
        $expectedStatusCode = 409;
        $expectedStatusMessage = 'Conflict';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns429WhenHandleRequestThrowsThrottleLimitExceededException()
    {
        $exception = new ThrottleLimitExceededException();
        $expectedStatusCode = 429;
        $expectedStatusMessage = 'Too Many Requests';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns500WhenHandleRequestThrowsMethodNotFoundException()
    {
        $exception = new MethodNotFoundException();
        $expectedStatusCode = 500;
        $expectedStatusMessage = 'Internal Server Error';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns500WhenHandleRequestThrowsException()
    {
        $exception = new \Exception();
        $expectedStatusCode = 500;
        $expectedStatusMessage = 'Internal Server Error';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    protected function assertCreateWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage)
    {
        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create')->willThrowException($exception);;

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory, new NullLogger());

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    protected function assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage)
    {
        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedResponse->expects($this->once())->method('withStatus')->with($expectedStatusCode, $expectedStatusMessage)->willReturn($mockedResponse);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willThrowException($exception);

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory, new NullLogger());

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    //TODO: Test all logger calls that are expected are called.

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

        $mockedAPIResponse = $this->getMockBuilder('\LunixREST\Server\APIResponse\APIResponse')->disableOriginalConstructor()->getMock();
        $mockedAPIResponse->method('getMIMEType')->willReturn($expectedMIMEType);
        $mockedAPIResponse->method('getAsDataStream')->willReturn($mockedDataStream);

        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedServer->method('handleRequest')->willReturn($mockedAPIResponse);

        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\RequestFactory\RequestFactory')->getMock();
        $mockedRequestFactory->method('create');

        $httpServer = new HTTPServer($mockedServer, $mockedRequestFactory, new NullLogger());

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();

        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testDumpResponseSetsStatusLine()
    {
        $protocol = 1.1;
        $reasonPhrase = "OK";
        $statusCode = 200;
        $headers = [];
        $bodyText = "";

        $expectedHeaderCall = ["HTTP/$protocol $statusCode $reasonPhrase", true, $statusCode];

        $mockedResponse = $this->buildResponseMock($protocol, $reasonPhrase, $statusCode, $headers, $bodyText);

        ob_start();
        HTTPServer::dumpResponse($mockedResponse);
        $body = ob_get_contents();
        ob_end_clean();

        $this->assertContains($expectedHeaderCall, self::$headerCalls);
    }

    public function testDumpResponseSetsArbitraryHeader()
    {
        $protocol = 0;
        $reasonPhrase = "";
        $statusCode = 0;
        $headers = ["Content-Type" => ["application/json"]];
        $bodyText = "";

        $expectedHeaderCall = ["Content-Type: application/json", false, null];

        $mockedResponse = $this->buildResponseMock($protocol, $reasonPhrase, $statusCode, $headers, $bodyText);

        ob_start();
        HTTPServer::dumpResponse($mockedResponse);
        $body = ob_get_contents();
        ob_end_clean();

        $this->assertContains($expectedHeaderCall, self::$headerCalls);
    }

    public function testDumpResponseOutputsBody()
    {
        $protocol = 0;
        $reasonPhrase = "";
        $statusCode = 0;
        $headers = [];
        $bodyText = "The quick brown fox jumps over the lazy dog.\n\n\0asdasd";

        $mockedResponse = $this->buildResponseMock($protocol, $reasonPhrase, $statusCode, $headers, $bodyText);

        ob_start();
        HTTPServer::dumpResponse($mockedResponse);
        $body = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($bodyText, $body);
    }

    private function buildResponseMock($protocol, $reasonPhrase, $statusCode, $headers, $bodyString)
    {
        $temp = fopen('php://temp', 'r+');
        fwrite($temp, $bodyString);
        fseek($temp, 0);

        $mockedBody = $this->getMockBuilder('\Psr\Http\Message\StreamInterface')->getMock();
        $mockedBody->method('eof')->willReturnCallback(function() use ($temp){
            return feof($temp);
        });
        $mockedBody->method('read')->willReturnCallback(function($offset) use ($temp){
            return fread($temp, $offset);
        });

        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('getProtocolVersion')->willReturn($protocol);
        $mockedResponse->method('getReasonPhrase')->willReturn($reasonPhrase);
        $mockedResponse->method('getStatusCode')->willReturn($statusCode);
        $mockedResponse->method('getHeaders')->willReturn($headers);
        $mockedResponse->method('getBody')->willReturn($mockedBody);
        return $mockedResponse;
    }
}
