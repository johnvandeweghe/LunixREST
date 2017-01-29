<?php
namespace LunixREST\Endpoint;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CachingLoggingEndpointFactory
 * @package LunixREST\Endpoint
 */
abstract class CachingLoggingEndpointFactory implements EndpointFactory
{
    /**
     * @var CacheItemPoolInterface
     */
    protected $cachePool;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * CachingEndpointFactory constructor.
     * @param CacheItemPoolInterface $cachePool
     * @param LoggerInterface $logger
     */
    public function __construct(CacheItemPoolInterface $cachePool, LoggerInterface $logger)
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
        $endpoint = $this->getCachingLoggingEndpoint($name, $version);
        $endpoint->setCachePool($this->cachePool);
        $endpoint->setLogger($this->logger);
        return $endpoint;
    }

    /**
     * @param string $name
     * @param string $version
     * @return CachingLoggingEndpoint
     */
    public abstract function getCachingLoggingEndpoint(string $name, string $version): CachingLoggingEndpoint;
}
