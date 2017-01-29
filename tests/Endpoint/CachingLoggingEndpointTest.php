<?php
namespace LunixREST\Endpoint;

class CachingLoggingEndpointTest extends \PHPUnit_Framework_TestCase
{
    public function testSetterDoesntExplode()
    {
        $mockedCachePool = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')->getMock();
        $cachingEndpoint = $this->getMockForAbstractClass('\LunixREST\Endpoint\CachingLoggingEndpoint');

        //Method provided by the abstract mocker
        $cachingEndpoint->setCachePool($mockedCachePool);
    }
}
