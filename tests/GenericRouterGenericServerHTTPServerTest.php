<?php
namespace LunixREST;

use LunixREST\RequestFactory\RequestFactory;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnableToCreateEndpointException;
use LunixREST\Server\Router\Exceptions\MethodNotFoundException;
use LunixREST\Server\Server;
use Psr\Log\LoggerInterface;

class GenericRouterGenericServerHTTPServerTest extends GenericServerHTTPServerTest
{
    protected function getHTTPServer(
        Server $server,
        RequestFactory $requestFactory,
        LoggerInterface $logger
    ): HTTPServer {
        return new GenericRouterGenericServerHTTPServer($server, $requestFactory, $logger);
    }

    protected function getMockedServer(): \PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockBuilder('\LunixREST\Server\GenericRouterGenericServer')->disableOriginalConstructor()->getMock();
    }

    public function testHandleRequestReturns400WhenHandleRequestThrowsInvalidRequestException()
    {
        $exception = new InvalidRequestException();
        $expectedStatusCode = 400;
        $expectedStatusMessage = 'Bad Request';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns404WhenHandleRequestThrowsElementNotFoundException()
    {
        $exception = new ElementNotFoundException();
        $expectedStatusCode = 404;
        $expectedStatusMessage = 'Not Found';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns404WhenHandleRequestThrowsUnableToCreateEndpointException()
    {
        $exception = new UnableToCreateEndpointException();
        $expectedStatusCode = 404;
        $expectedStatusMessage = 'Not Found';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns404WhenHandleRequestThrowsUnsupportedMethodException()
    {
        $exception = new UnsupportedMethodException();
        $expectedStatusCode = 404;
        $expectedStatusMessage = 'Not Found';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns409WhenHandleRequestThrowsElementConflictException()
    {
        $exception = new ElementConflictException();
        $expectedStatusCode = 409;
        $expectedStatusMessage = 'Conflict';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns500WhenHandleRequestThrowsMethodNotFoundException()
    {
        $exception = new MethodNotFoundException();
        $expectedStatusCode = 500;
        $expectedStatusMessage = 'Internal Server Error';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }

    public function testHandleRequestReturns500WhenHandleRequestThrowsEndpointExecutionException()
    {
        $exception = new EndpointExecutionException();
        $expectedStatusCode = 500;
        $expectedStatusMessage = 'Internal Server Error';

        $this->assertHandleRequestWithExceptionReturnsExpectedStatusCodeAndMessage($exception, $expectedStatusCode, $expectedStatusMessage);
    }
}
