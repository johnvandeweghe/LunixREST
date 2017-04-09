<?php
namespace LunixREST\Server;

use LunixREST\APIResponse\APIResponseData;

class GenericServerTest extends \PHPUnit\Framework\TestCase
{
    public function testThrowsExceptionForInvalidKey()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\APIResponse\ResponseFactory')->getMock();
        $mockedRouter = $this->getMockBuilder('\LunixREST\Server\Router')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $server = new GenericServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\InvalidAPIKeyException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForThrottleExceeded()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(true);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\APIResponse\ResponseFactory')->getMock();

        $mockedRouter = $this->getMockBuilder('\LunixREST\Server\Router')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $server = new GenericServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\ThrottleLimitExceededException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForEmptySupportedMimeTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\APIResponse\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn([]);

        $mockedRouter = $this->getMockBuilder('\LunixREST\Server\Router')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = new GenericServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForNonSupportedMimeTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\APIResponse\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['text/html']);

        $mockedRouter = $this->getMockBuilder('\LunixREST\Server\Router')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = new GenericServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForInvalidAPIAccess()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\APIResponse\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['application/json']);

        $mockedRouter = $this->getMockBuilder('\LunixREST\Server\Router')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = new GenericServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\AccessDeniedException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForInvalidAPIAccessViaStarTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\APIResponse\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['application/json']);

        $mockedRouter = $this->getMockBuilder('\LunixREST\Server\Router')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['*/*']);

        $server = new GenericServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\AccessDeniedException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForInvalidAPIAccessViaEmptyTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\APIResponse\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['application/json']);

        $mockedRouter = $this->getMockBuilder('\LunixREST\Server\Router')->getMock();
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn([]);

        $server = new GenericServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\AccessDeniedException');

        $server->handleRequest($mockedRequest);
    }

    public function testLogsRequestAndRoutesAndReturnsResponseData()
    {
        $method = 'get';
        $responseData = new APIResponseData(["foo" => "bar"]);
        $mimeTypes = ['application/json'];

        $mockedAccessControl = $this->getMockBuilder('\LunixREST\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);
        $mockedThrottle->expects($this->once())->method('logRequest');

        $mockedResponse = $this->getMockBuilder('\LunixREST\APIResponse\APIResponse')->disableOriginalConstructor()->getMock();

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\APIResponse\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn($mimeTypes);
        $mockedResponseFactory->expects($this->once())->method('getResponse')->with($responseData, $mimeTypes)->willReturn($mockedResponse);

        $mockedRouter = $this->getMockBuilder('\LunixREST\Server\Router')->getMock();
        $mockedRouter->expects($this->once())->method('route')->willReturn($responseData);

        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn($mimeTypes);
        $mockedRequest->method('getMethod')->willReturn($method);
        $mockedRequest->method('getEndpoint')->willReturn('testEndpoint');
        $mockedRequest->method('getVersion')->willReturn('v1.0');

        $server = new GenericServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->assertEquals($mockedResponse, $server->handleRequest($mockedRequest));
    }
}
