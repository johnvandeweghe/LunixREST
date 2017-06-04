<?php
namespace LunixREST\Server\Router\Endpoint;

use Psr\Cache\CacheItemPoolInterface;

/**
 * An extension of a LoggingEndpoint that has a PSR CacheItemPoolInterface available to it. Used with the CachingEndpointFactory.
 * Class CachingEndpoint
 * @package LunixREST\Endpoint
 * @deprecated This has been deprecated in favor of using the CacheItemPoolAwareTrait.
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
