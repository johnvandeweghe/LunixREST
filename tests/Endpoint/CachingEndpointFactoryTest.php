<?php
namespace LunixREST\Endpoint;

class CachingEndpointFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testSetsCachePoolAndLoggerOnCachingEndpoint()
    {
        $mockedCachePool = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')->getMock();
        $mockedLogger = $this->getMockBuilder('\Psr\Log\LoggerInterface')->getMock();
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\CachingEndpoint')->getMock();

        $endpointFactory = $this->getMockForAbstractClass('\LunixREST\Endpoint\CachingEndpointFactory', [$mockedCachePool, $mockedLogger]);
        $endpointFactory->method('getCachingEndpoint')->willReturn($mockedEndpoint);

        $mockedEndpoint->expects($this->once())->method('setCachePool')->with($mockedCachePool);
        $mockedEndpoint->expects($this->once())->method('setLogger')->with($mockedLogger);

        //Method provided by the abstract mocker
        $endpointFactory->getEndpoint('', '');
    }
}
