<?php
namespace LunixREST\Endpoint;

class LoggingEndpointFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSetsLoggerOnLoggingEndpoint()
    {
        $mockedLogger = $this->getMockBuilder('\Psr\Log\LoggerInterface')->getMock();
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\LoggingEndpoint')->getMock();

        $loggingEndpointFactoryTest = $this->getMockForAbstractClass('\LunixREST\Endpoint\LoggingEndpointFactory', [$mockedLogger]);
        $loggingEndpointFactoryTest->method('getLoggingEndpoint')->willReturn($mockedEndpoint);

        $mockedEndpoint->expects($this->once())->method('setLogger')->with($mockedLogger);

        //Method provided by the abstract mocker
        $loggingEndpointFactoryTest->getEndpoint('', '');
    }
}
