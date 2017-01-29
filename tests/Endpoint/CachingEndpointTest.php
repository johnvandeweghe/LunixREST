<?php
namespace LunixREST\Endpoint;

class CachingEndpointTest extends \PHPUnit_Framework_TestCase
{
    public function testSetterDoesntExplode()
    {
        $mockedCachePool = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')->getMock();
        $cachingEndpoint = $this->getMockForAbstractClass('\LunixREST\Endpoint\CachingEndpoint');

        $cachingEndpoint->setCachePool($mockedCachePool);
    }
}
