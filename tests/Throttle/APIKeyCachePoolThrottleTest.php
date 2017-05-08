<?php
namespace LunixREST\Throttle;

use Psr\Cache\CacheItemPoolInterface;

class APIKeyCachePoolThrottleTest extends CachePoolThrottleTest
{
    private const CACHE_KEY_PREFIX = "throttle_cache_";

    protected function mockThrottle(CacheItemPoolInterface $cacheItemPool, $limit = 60, $perXseconds = 60): Throttle
    {
        return new APIKeyCachePoolThrottle($cacheItemPool, $limit, $perXseconds, self::CACHE_KEY_PREFIX);
    }

    public function testShouldThrottleUsesExpectedKey()
    {
        $apiKey = "asdasdrfewfg4er658g74ert68g4ed6fg8hb";
        $value = 60;
        $limit = 60;
        $mockedCacheItem = $this->getMockBuilder('Psr\Cache\CacheItemInterface')->getMock();
        $mockedCacheItem->method('get')->willReturn($value);
        $mockedCacheItemPool = $this->getMockBuilder('Psr\Cache\CacheItemPoolInterface')->getMock();
        $throttle = $this->mockThrottle($mockedCacheItemPool, $limit);
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $mockedRequest->method('getAPIKey')->willReturn($apiKey);

        $mockedCacheItemPool->expects($this->once())->method('getItem')->with(self::CACHE_KEY_PREFIX . $apiKey)->willReturn($mockedCacheItem);

        $throttle->shouldThrottle($mockedRequest);
    }
}
