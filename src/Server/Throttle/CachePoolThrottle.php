<?php
namespace LunixREST\Server\Throttle;

use LunixREST\Server\APIRequest\APIRequest;
use Psr\Cache\CacheItemPoolInterface;

/**
 * A Throttle implementation that relies on an underlying CacheItemPool, and allows a certain number requests in a certain number of seconds.
 * Class CachePoolThrottle
 * @package LunixREST\Server\Throttle
 */
abstract class CachePoolThrottle implements Throttle
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $perXSeconds;

    /**
     * CachePoolThrottle constructor.
     * @param CacheItemPoolInterface $cacheItemPool
     * @param int $limit
     * @param int $perXSeconds
     */
    public function __construct(CacheItemPoolInterface $cacheItemPool, int $limit = 60, int $perXSeconds = 60)
    {
        $this->cacheItemPool = $cacheItemPool;
        $this->limit = $limit;
        $this->perXSeconds = $perXSeconds;
    }

    /**
     * Returns true if the given request should be throttled in our implementation
     * @param \LunixREST\Server\APIRequest\APIRequest $request
     * @return bool
     */
    public function shouldThrottle(APIRequest $request): bool
    {
        $item = $this->cacheItemPool->getItem($this->deriveCacheKey($request));

        return $item->get() >= $this->limit;
    }

    /**
     * Log that a request took place
     * @param \LunixREST\Server\APIRequest\APIRequest $request
     */
    public function logRequest(APIRequest $request): void
    {
        $item = $this->cacheItemPool->getItem($this->deriveCacheKey($request));

        if($requestCount = $item->get()) {
            $item->set($requestCount + 1);
        } else {
            $item->set(1)->expiresAfter($this->perXSeconds);
        }

        $this->cacheItemPool->save($item);
    }

    /**
     * @param APIRequest $request
     * @return string
     */
    protected abstract function deriveCacheKey(APIRequest $request): string;

    /**
     * @return CacheItemPoolInterface
     */
    public function getCacheItemPool(): CacheItemPoolInterface
    {
        return $this->cacheItemPool;
    }
}
