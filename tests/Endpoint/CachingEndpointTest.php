<?php
namespace LunixREST\Endpoint;

class CachingEndpointTest extends \PHPUnit_Framework_TestCase
{
    public function testSetterDoesntExplode()
    {
        $mockedCachePool = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')->getMock();
        $cachingEndpoint = $this->getMockForAbstractClass('\LunixREST\Endpoint\CachingEndpoint');

        //Method provided by the abstract mocker
        $cachingEndpoint->setCachePool($mockedCachePool);
    }
}
