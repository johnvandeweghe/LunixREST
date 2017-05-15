<?php
namespace LunixREST\Server\Router\EndpointFactory;

use LunixREST\Server\Router\Endpoint\Endpoint;
use LunixREST\Server\Router\Endpoint\LoggingEndpoint;
use Psr\Log\LoggerInterface;

/**
 * An EndpointFactory implementation that sets the LoggerInterface on LoggingEndpoints.
 * Class LoggingEndpointFactory
 * @package LunixREST\Server\Router\EndpointFactory
 */
abstract class LoggingEndpointFactory implements EndpointFactory
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * LoggingEndpointFactory constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $name
     * @param string $version
     * @return Endpoint
     */
    public function getEndpoint(string $name, string $version): Endpoint
    {
        $endpoint = $this->getLoggingEndpoint($name, $version);
        $endpoint->setLogger($this->logger);
        return $endpoint;
    }

    /**
     * @param string $name
     * @param string $version
     * @return LoggingEndpoint
     */
    protected abstract function getLoggingEndpoint(string $name, string $version): LoggingEndpoint;
}
