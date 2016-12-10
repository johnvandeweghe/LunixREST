<?php
namespace LunixREST\Endpoint;

use LunixREST\Endpoint\Exceptions\UnknownEndpointException;

interface EndpointFactory {
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
