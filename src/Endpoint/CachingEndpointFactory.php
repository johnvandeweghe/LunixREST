<?php
namespace LunixREST\Endpoint;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * An EndpointFactory that extends LoggingEndpointFactory, using a CachingEndpoint by setting a CachePoolInterface on the Endpoint.
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

    protected function getLoggingEndpoint(string $name, string $version): LoggingEndpoint
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
    protected abstract function getCachingEndpoint(string $name, string $version): CachingEndpoint;
}
