<?php
namespace LunixREST\Endpoint;

use Psr\Cache\CacheItemPoolInterface;

/**
 * Class CachingEndpointFactory
 * @package LunixREST\Endpoint
 */
abstract class CachingEndpointFactory implements EndpointFactory
{
    /**
     * @var CacheItemPoolInterface
     */
    protected $cachePool;

    /**
     * CachingEndpointFactory constructor.
     * @param CacheItemPoolInterface $cachePool
     */
    public function __construct(CacheItemPoolInterface $cachePool)
    {
        $this->cachePool = $cachePool;
    }

    /**
     * @param string $name
     * @param string $version
     * @return Endpoint
     */
    public function getEndpoint(string $name, string $version): Endpoint
    {
        $endpoint = $this->getCachingEndpoint($name, $version);
        $endpoint->setCachePool($this->cachePool);
        return $endpoint;
    }

    /**
     * @param string $name
     * @param string $version
     * @return CachingEndpoint
     */
    public abstract function getCachingEndpoint(string $name, string $version): CachingEndpoint;
}
