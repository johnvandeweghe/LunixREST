<?php
namespace LunixREST\Server\Throttle;

use LunixREST\Server\APIRequest\APIRequest;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class APIKeyCachePoolThrottle
 * @package LunixREST\Server\Throttle
 */
class APIKeyCachePoolThrottle extends CachePoolThrottle
{
    /**
     * @var string
     */
    private $keyPrefix;

    /**
     * APIKeyCachePoolThrottle constructor.
     * @param CacheItemPoolInterface $cacheItemPool
     * @param int $limit
     * @param int $perXSeconds
     * @param string $keyPrefix
     */
    public function __construct(CacheItemPoolInterface $cacheItemPool, $limit = 60, $perXSeconds = 60, $keyPrefix = '')
    {
        parent::__construct($cacheItemPool, $limit, $perXSeconds);
        $this->keyPrefix = $keyPrefix;
    }

    /**
     * @param APIRequest $request
     * @return string
     */
    protected function deriveCacheKey(APIRequest $request): string
    {
        return $this->keyPrefix . $request->getApiKey();
    }
}
