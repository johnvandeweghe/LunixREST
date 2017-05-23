<?php
namespace LunixREST;

use LunixREST\RequestFactory\RequestFactory;
use LunixREST\Server\Exceptions\AccessDeniedException;
use LunixREST\Server\Exceptions\InvalidAPIKeyException;
use LunixREST\Server\Exceptions\ThrottleLimitExceededException;
use LunixREST\Server\ResponseFactory\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Server\ResponseFactory\Exceptions\UnableToCreateAPIResponseException;
use LunixREST\Server\Router\Exceptions\UnableToRouteRequestException;
use LunixREST\Server\Server;
use Psr\Log\LoggerInterface;

class GenericServerHTTPServerTest extends HTTPServerTest
{
    protected function getHTTPServer(
        Server $server,
        RequestFactory $requestFactory,
        LoggerInterface $logger
    ): HTTPServer {
        return new GenericServerHTTPServer($server, $requestFactory, $logger);
    }

    protected function getMockedServer(): \PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockBuilder('\LunixREST\Server\GenericServer')->disableOriginalConstructor()->getMock();
    }

    public function testHandleRequestReturns429WhenHandleRequestThrowsThrottleLimitExceededException()
    {
        $exception = new ThrottleLimitExceededException();
        $expectedStatusCode = 429;
        $expectedStatusMessage = 'Too Many Requests';

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

    public function testHandleRequestReturns403WhenHandleRequestThrowsInvalidAPIKeyException()
    {
        $exception = new InvalidAPIKeyException();
        $expectedStatusCode = 403;
        $expectedStatusMessage = 'Access Denied';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns500WhenHandleRequestThrowsUnableToCreateAPIResponseException()
    {
        $exception = new UnableToCreateAPIResponseException();
        $expectedStatusCode = 500;
        $expectedStatusMessage = 'Internal Server Error';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns500WhenHandleRequestThrowsUnableToRouteRequestException()
    {
        $exception = new UnableToRouteRequestException();
        $expectedStatusCode = 500;
        $expectedStatusMessage = 'Internal Server Error';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }
}
