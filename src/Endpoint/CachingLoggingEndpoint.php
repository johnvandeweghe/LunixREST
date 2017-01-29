<?php
namespace LunixREST\Endpoint;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Class CachingEndpoint
 * @package LunixREST\Endpoint
 */
abstract class CachingLoggingEndpoint implements Endpoint
{
    use LoggerAwareTrait;

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
