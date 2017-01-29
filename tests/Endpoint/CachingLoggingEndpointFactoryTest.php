<?php
namespace LunixREST\Endpoint;

class CachingLoggingEndpointFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSetsCachePoolAndLoggerOnCachingLoggingEndpoint()
    {
        $mockedCachePool = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')->getMock();
        $mockedLogger = $this->getMockBuilder('\Psr\Log\LoggerInterface')->getMock();
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\CachingLoggingEndpoint')->getMock();

        $endpointFactory = $this->getMockForAbstractClass('\LunixREST\Endpoint\CachingLoggingEndpointFactory', [$mockedCachePool, $mockedLogger]);
        $endpointFactory->method('getCachingLoggingEndpoint')->willReturn($mockedEndpoint);

        $mockedEndpoint->expects($this->once())->method('setCachePool')->with($mockedCachePool);
        $mockedEndpoint->expects($this->once())->method('setLogger')->with($mockedLogger);

        //Method provided by the abstract mocker
        $endpointFactory->getEndpoint('', '');
    }
}
