<?php
namespace LunixREST\Server\Router\EndpointFactory;

class LoggingEndpointFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testSetsLoggerOnLoggingEndpoint()
    {
        $mockedLogger = $this->getMockBuilder('\Psr\Log\LoggerInterface')->getMock();
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\LoggingEndpoint')->getMock();

        $endpointFactory = $this->getMockForAbstractClass('\LunixREST\Server\Router\EndpointFactory\LoggingEndpointFactory', [$mockedLogger]);
        $endpointFactory->method('getLoggingEndpoint')->willReturn($mockedEndpoint);

        $mockedEndpoint->expects($this->once())->method('setLogger')->with($mockedLogger);

        //Method provided by the abstract mocker
        $endpointFactory->getEndpoint('', '');
    }
}
