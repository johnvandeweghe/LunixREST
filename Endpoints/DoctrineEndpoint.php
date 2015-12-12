<?php
namespace LunixREST\Endpoints;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineEndpoint
 * @package LunixREST\Endpoints
 */
abstract class DoctrineEndpoint extends Endpoint {
    protected $entityManager;

    public function setEntityManager(EntityManager $em){
        $this->entityManager = $em;
    }
}
