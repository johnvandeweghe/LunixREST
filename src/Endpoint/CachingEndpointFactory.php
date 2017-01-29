<?php
namespace LunixREST\Endpoint;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CachingEndpointFactory
 * @package LunixREST\Endpoint
 */
abstract class CachingEndpointFactory extends LoggingEndpointFactory
{
    /**
     * @var CacheItemPoolInterface
     */
    protected $cachePool;

    /**
     * CachingEndpointFactory constructor.
     * @param CacheItemPoolInterface $cachePool
     * @param LoggerInterface $logger
     */
    public function __construct(CacheItemPoolInterface $cachePool, LoggerInterface $logger)
    {
        $this->cachePool = $cachePool;
        parent::__construct($logger);
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
        $endpoint->setLogger($this->logger);
        return $endpoint;
    }

    /**
     * @param string $name
     * @param string $version
     * @return CachingEndpoint
     */
    public abstract function getCachingEndpoint(string $name, string $version): CachingEndpoint;
}
