<?php
namespace LunixREST\Endpoint;

use Doctrine\ORM\EntityManager;
use LunixREST\Endpoint\Exceptions\UnknownEndpointException;

/**
 * Assumes all endpoints in the $endpointNamespace are DoctrineEndpoints (and does not check) and instantiates
 * them with an EntityManager
 * Class DoctrineNamespaceEndpointFactory
 * @package LunixREST\Endpoint
 */
class DoctrineNamespaceEndpointFactory extends NamespaceEndpointFactory
{
    protected $entityManager;

    public function __construct(string $endpointNamespace, EntityManager $em)
    {
        parent::__construct($endpointNamespace);
        $this->entityManager = $em;
    }

    /**
     * Basically assume endpoints are doctrine endpoints
     * @param string $name
     * @param string $version
     * @return Endpoint
     * @throws UnknownEndpointException
     */
    public function getEndpoint(string $name, string $version): Endpoint
    {
        $className = $this->buildVersionedEndpointNamespace($version) . $name;
        return new $className($this->entityManager);
    }
}
