<?php
namespace LunixREST\Server;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowsExceptionForInvalidKey()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Response\ResponseFactory')->getMock();
        $mockedEndpointFactory = $this->getMockBuilder('\LunixREST\Endpoint\EndpointFactory')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();

        $server = new Server($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedEndpointFactory);

        $this->expectException('\LunixREST\Exceptions\InvalidAPIKeyException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForThrottleExceeded()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(true);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Response\ResponseFactory')->getMock();

        $mockedEndpointFactory = $this->getMockBuilder('\LunixREST\Endpoint\EndpointFactory')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();

        $server = new Server($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedEndpointFactory);

        $this->expectException('\LunixREST\Exceptions\ThrottleLimitExceededException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForEmptySupportedMimeTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Response\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn([]);

        $mockedEndpointFactory = $this->getMockBuilder('\LunixREST\Endpoint\EndpointFactory')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = new Server($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedEndpointFactory);

        $this->expectException('\LunixREST\Response\Exceptions\NotAcceptableResponseTypeException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForNonSupportedMimeTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Response\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['text/html']);

        $mockedEndpointFactory = $this->getMockBuilder('\LunixREST\Endpoint\EndpointFactory')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = new Server($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedEndpointFactory);

        $this->expectException('\LunixREST\Response\Exceptions\NotAcceptableResponseTypeException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForInvalidAPIAccess()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Response\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['application/json']);

        $mockedEndpointFactory = $this->getMockBuilder('\LunixREST\Endpoint\EndpointFactory')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = new Server($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedEndpointFactory);

        $this->expectException('\LunixREST\Exceptions\AccessDeniedException');

        $server->handleRequest($mockedRequest);
    }

    public function testLogsRequestAndRoutesAndReturnsResponseData()
    {
        $method = 'get';

        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);
        $mockedThrottle->expects($this->once())->method('logRequest');

        $mockedResponse = $this->getMockBuilder('\LunixREST\Response\Response')->getMock();

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Response\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['application/json']);
        $mockedResponseFactory->method('getResponse')->willReturn($mockedResponse);

        $mockedResponseData = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $mockedEndpoint->expects($this->once())->method($method)->willReturn($mockedResponseData);

        $mockedEndpointFactory = $this->getMockBuilder('\LunixREST\Endpoint\EndpointFactory')->getMock();
        $mockedEndpointFactory->method('getEndpoint')->willReturn($mockedEndpoint);

        $mockedRequest = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);
        $mockedRequest->method('getMethod')->willReturn($method);
        $mockedRequest->method('getEndpoint')->willReturn('testEndpoint');
        $mockedRequest->method('getVersion')->willReturn('v1.0');

        $server = new Server($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedEndpointFactory);

        $this->assertEquals($mockedResponse, $server->handleRequest($mockedRequest));
    }
}
