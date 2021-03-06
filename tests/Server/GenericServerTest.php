<?php
namespace LunixREST\Server;

use LunixREST\Server\AccessControl\AccessControl;
use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\ResponseFactory\ResponseFactory;
use LunixREST\Server\Router\Router;
use LunixREST\Server\Throttle\Throttle;

class GenericServerTest extends \PHPUnit\Framework\TestCase
{
    protected function getMockedRouter(): \PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->getMockBuilder('\LunixREST\Server\Router\Router')->getMock();

        return $mock;
    }

    protected function getServer(
        AccessControl $accessControl,
        Throttle $throttle,
        ResponseFactory $responseFactory,
        Router $router
    ): GenericServer
    {
        return new GenericServer($accessControl, $throttle, $responseFactory, $router);
    }

    public function testThrowsExceptionForInvalidKey()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\Server\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Server\Throttle\Throttle')->getMock();
        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Server\ResponseFactory\ResponseFactory')->getMock();
        $mockedRouter = $this->getMockedRouter();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $server = $this->getServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\InvalidAPIKeyException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForThrottleExceeded()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\Server\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Server\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(true);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Server\ResponseFactory\ResponseFactory')->getMock();

        $mockedRouter = $this->getMockedRouter();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $server = $this->getServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\ThrottleLimitExceededException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForEmptySupportedMimeTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\Server\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Server\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Server\ResponseFactory\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn([]);

        $mockedRouter = $this->getMockedRouter();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = $this->getServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\ResponseFactory\Exceptions\NotAcceptableResponseTypeException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForNonSupportedMimeTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\Server\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Server\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Server\ResponseFactory\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['text/html']);

        $mockedRouter = $this->getMockedRouter();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = $this->getServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\ResponseFactory\Exceptions\NotAcceptableResponseTypeException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForInvalidAPIAccess()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\Server\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Server\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Server\ResponseFactory\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['application/json']);

        $mockedRouter = $this->getMockedRouter();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['application/json']);

        $server = $this->getServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\AccessDeniedException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForInvalidAPIAccessViaStarTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\Server\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Server\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Server\ResponseFactory\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['application/json']);

        $mockedRouter = $this->getMockedRouter();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn(['*/*']);

        $server = $this->getServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\AccessDeniedException');

        $server->handleRequest($mockedRequest);
    }

    public function testThrowsExceptionForInvalidAPIAccessViaEmptyTypes()
    {
        $mockedAccessControl = $this->getMockBuilder('\LunixREST\Server\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(false);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Server\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Server\ResponseFactory\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn(['application/json']);

        $mockedRouter = $this->getMockedRouter();
        $mockedRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn([]);

        $server = $this->getServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->expectException('\LunixREST\Server\Exceptions\AccessDeniedException');

        $server->handleRequest($mockedRequest);
    }

    public function testLogsRequestAndRoutesAndReturnsResponseData()
    {
        $method = 'get';
        $responseData = new APIResponseData(["foo" => "bar"]);
        $mimeTypes = ['application/json'];

        $mockedAccessControl = $this->getMockBuilder('\LunixREST\Server\AccessControl\AccessControl')->getMock();
        $mockedAccessControl->method('validateKey')->willReturn(true);
        $mockedAccessControl->method('validateAccess')->willReturn(true);

        $mockedThrottle = $this->getMockBuilder('\LunixREST\Server\Throttle\Throttle')->getMock();
        $mockedThrottle->method('shouldThrottle')->willReturn(false);
        $mockedThrottle->expects($this->once())->method('logRequest');

        $mockedResponse = $this->getMockBuilder('\LunixREST\Server\APIResponse\APIResponse')->disableOriginalConstructor()->getMock();

        $mockedResponseFactory = $this->getMockBuilder('\LunixREST\Server\ResponseFactory\ResponseFactory')->getMock();
        $mockedResponseFactory->method('getSupportedMIMETypes')->willReturn($mimeTypes);
        $mockedResponseFactory->expects($this->once())->method('getResponse')->with($responseData, $mimeTypes)->willReturn($mockedResponse);

        $mockedRouter = $this->getMockedRouter();
        $mockedRouter->expects($this->once())->method('route')->willReturn($responseData);

        $mockedRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAcceptableMIMETypes')->willReturn($mimeTypes);
        $mockedRequest->method('getMethod')->willReturn($method);
        $mockedRequest->method('getEndpoint')->willReturn('testEndpoint');
        $mockedRequest->method('getVersion')->willReturn('v1.0');

        $server = $this->getServer($mockedAccessControl, $mockedThrottle, $mockedResponseFactory, $mockedRouter);

        $this->assertEquals($mockedResponse, $server->handleRequest($mockedRequest));
    }
}
