<?php
namespace LunixREST\Endpoint;

use Psr\Cache\CacheItemPoolInterface;

/**
 * Class CachingEndpoint
 * @package LunixREST\Endpoint
 */
abstract class CachingEndpoint extends LoggingEndpoint
{
    /**
     * @var CacheItemPoolInterface
     */
    protected $cachePool;

    /**
     * @param CacheItemPoolInterface $cacheItemPool
     */
    public function setCachePool(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cachePool = $cacheItemPool;
    }
}