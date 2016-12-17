<?php
namespace LunixREST\Endpoint;
use Doctrine\ORM\EntityManager;

/**
 * A DoctrineEndpoint, for use with a EndpointFactory that can construct by passing in an EntityManager
 * Class DoctrineEndpoint
 * @package LunixREST\Endpoints
 */
class DoctrineEndpoint extends DefaultEndpoint {
    protected $entityManager;

    public function __construct(EntityManager $em){
        $this->entityManager = $em;
    }
}
