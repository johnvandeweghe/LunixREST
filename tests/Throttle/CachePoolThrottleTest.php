<?php
namespace LunixREST\Throttle;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;

class CachePoolThrottleTest extends TestCase
{
    protected function mockCacheItemPoolAndItem(bool $isHit, $value = null)
    {
        $mockedCacheItem = $this->getMockBuilder('Psr\Cache\CacheItemInterface')->getMock();
        $mockedCacheItem->method('get')->willReturn($value);
        $mockedCacheItem->method('isHit')->willReturn($isHit);
        $mockedCacheItemPool = $this->getMockBuilder('Psr\Cache\CacheItemPoolInterface')->getMock();
        $mockedCacheItemPool->method('getItem')->willReturn($mockedCacheItem);
        return $mockedCacheItemPool;
    }

    protected function mockThrottle(CacheItemPoolInterface $cacheItemPool, $limit = 60, $perXseconds = 60): Throttle
    {
        $throttle = $this->getMockBuilder('\LunixREST\Throttle\CachePoolThrottle')
            ->setConstructorArgs([$cacheItemPool, $limit, $perXseconds])->getMockForAbstractClass();
        $throttle->method('deriveCacheKey')->willReturn('');
        /** @var Throttle $throttle */
        return $throttle;
    }

    public function testGetCacheItemPoolReturnsConstructedItemPool()
    {
        $mockedCacheItemPool = $this->getMockBuilder('Psr\Cache\CacheItemPoolInterface')->getMock();
        $throttle = $this->mockThrottle($mockedCacheItemPool);

        /**
         * @var CachePoolThrottle $throttle
         */
        $returnedCacheItemPool = $throttle->getCacheItemPool();

        $this->assertEquals($mockedCacheItemPool, $returnedCacheItemPool);
    }

    public function testShouldThrottleReturnsFalseWhenItemReturnsAsMiss()
    {
        $mockedCacheItemPool =  $this->mockCacheItemPoolAndItem(false);
        $throttle = $this->mockThrottle($mockedCacheItemPool);
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $shouldThrottle = $throttle->shouldThrottle($mockedRequest);

        $this->assertFalse($shouldThrottle);
    }

    public function testShouldThrottleReturnsFalseWhenItemReturnsAsUnderLimit()
    {
        $value = 30;
        $limit = 60;
        $mockedCacheItemPool =  $this->mockCacheItemPoolAndItem(true, $value);
        $throttle = $this->mockThrottle($mockedCacheItemPool, $limit);
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $shouldThrottle = $throttle->shouldThrottle($mockedRequest);

        $this->assertFalse($shouldThrottle);
    }

    public function testShouldThrottleReturnsTrueWhenItemReturnsAsOverLimit()
    {
        $value = 61;
        $limit = 60;
        $mockedCacheItemPool =  $this->mockCacheItemPoolAndItem(true, $value);
        $throttle = $this->mockThrottle($mockedCacheItemPool, $limit);
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $shouldThrottle = $throttle->shouldThrottle($mockedRequest);

        $this->assertTrue($shouldThrottle);
    }

    public function testShouldThrottleReturnsTrueWhenItemReturnsAsAtLimit()
    {
        $value = 60;
        $limit = 60;
        $mockedCacheItemPool =  $this->mockCacheItemPoolAndItem(true, $value);
        $throttle = $this->mockThrottle($mockedCacheItemPool, $limit);
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $shouldThrottle = $throttle->shouldThrottle($mockedRequest);

        $this->assertTrue($shouldThrottle);
    }

    public function testLogRequestSavesKeyWithValueOf1AndExpiresInXSecondsWhenGetItemReturnsMiss()
    {
        $limit = 60;
        $xSeconds = 61;
        $mockedCacheItemPool = $this->mockCacheItemPoolAndItem(false);
        $mockedItem = $mockedCacheItemPool->getItem('');
        $throttle = $this->mockThrottle($mockedCacheItemPool, $limit, $xSeconds);
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $mockedItem->expects($this->once())->method('set')->with(1)->willReturn($mockedItem);
        $mockedItem->expects($this->once())->method('expiresAfter')->with($xSeconds)->willReturn($mockedItem);
        $mockedCacheItemPool->expects($this->once())->method('save')->with($mockedItem);

        $throttle->logRequest($mockedRequest);
    }

    public function testLogRequestSavesKeyWithIncrementedValueWhenGetItemReturnsHitWithValue()
    {
        $limit = 60;
        $xSeconds = 61;
        $value = 41;
        $mockedCacheItemPool = $this->mockCacheItemPoolAndItem(true, $value);
        $mockedItem = $mockedCacheItemPool->getItem('');
        $throttle = $this->mockThrottle($mockedCacheItemPool, $limit, $xSeconds);
        $mockedRequest = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();

        $mockedItem->expects($this->once())->method('set')->with($value + 1)->willReturn($mockedItem);
        $mockedCacheItemPool->expects($this->once())->method('save')->with($mockedItem);

        $throttle->logRequest($mockedRequest);
    }
}
