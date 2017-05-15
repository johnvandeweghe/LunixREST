<?php
namespace LunixREST\Server\Router\EndpointFactory;

use LunixREST\Server\Router\Endpoint\Endpoint;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnknownEndpointException;

/**
 * An interface that defines how to find an Endpoint from a name and version pulled from an APIRequest.
 * Interface EndpointFactory
 * @package LunixREST\Server\Router\Endpoint
 */
interface EndpointFactory
{
    /**
     * @param string $name
     * @param string $version
     * @return Endpoint
     * @throws UnknownEndpointException
     */
    public function getEndpoint(string $name, string $version): Endpoint;

    /**
     * @param string $version
     * @return string[]
     */
    public function getSupportedEndpoints(string $version): array;
}
