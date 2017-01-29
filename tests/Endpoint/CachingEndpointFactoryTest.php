<?php
namespace LunixREST\Endpoint;

class CachingEndpointFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSetsCachePoolOnCachingEndpoint()
    {
        $mockedCachePool = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')->getMock();
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\CachingEndpoint')->getMock();

        $loggingEndpointFactoryTest = $this->getMockForAbstractClass('\LunixREST\Endpoint\CachingEndpointFactory', [$mockedCachePool]);
        $loggingEndpointFactoryTest->method('getCachingEndpoint')->willReturn($mockedEndpoint);

        $mockedEndpoint->expects($this->once())->method('setCachePool')->with($mockedCachePool);

        //Method provided by the abstract mocker
        $loggingEndpointFactoryTest->getEndpoint('', '');
    }
}
