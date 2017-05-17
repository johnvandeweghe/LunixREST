<?php
namespace LunixREST\Server\Router\EndpointFactory;

use LunixREST\Server\Router\Endpoint\Endpoint;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnableToCreateEndpointException;
use LunixREST\Server\Router\EndpointFactory\Exceptions\UnknownEndpointException;


/**
 * Case insensitive registered endpoint factory that throws an exception on unknown endpoints.
 * Class RegisteredEndpointFactory
 * @package LunixREST\Server\Router\EndpointFactory
 */
class RegisteredEndpointFactory implements EndpointFactory
{
    /**
     * @var Endpoint[][]
     */
    protected $endpoints = [];

    /**
     * @param string $name
     * @param string $version
     * @param Endpoint $endpoint
     */
    public function register(string $name, string $version, Endpoint $endpoint)
    {
        if(!isset($this->endpoints[$version])) {
            $this->endpoints[$version] = [];
        }
        $this->endpoints[$version][strtolower($name)] = $endpoint;
    }

    /**
     * @param string $name
     * @param string $version
     * @return Endpoint
     * @throws UnableToCreateEndpointException
     * @throws UnknownEndpointException
     */
    public function getEndpoint(string $name, string $version): Endpoint
    {
        $lowercaseName = strtolower($name);
        if(!isset($this->endpoints[$version]) || !isset($this->endpoints[$version][$lowercaseName])) {
            throw new UnknownEndpointException('Could not find endpoint: ' . $name . ' of version: ' . $version);
        }

        return $this->endpoints[$version][$lowercaseName];
    }

    /**
     * @param string $version
     * @return string[]
     */
    public function getSupportedEndpoints(string $version): array
    {
        return array_keys($this->endpoints[$version] ?? []);
    }
}
