<?php
namespace LunixREST\Server\Router\Endpoint;

use Psr\Cache\CacheItemPoolInterface;

/**
 * This class makes the caching PSR match the trait pattern of the logging PSR.
 * Class CacheItemPoolAwareTrait
 * @package LunixREST\Server\Router\Endpoint
 */
trait CacheItemPoolAwareTrait
{
    /**
     * @var CacheItemPoolInterface
     */
    protected $cacheItemPool;

    /**
     * @param CacheItemPoolInterface $cacheItemPool
     */
    public function setCacheItemPool(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;
    }
}
