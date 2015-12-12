<?php
namespace LunixREST\Endpoints;

/**
 * Class DoctrineEndpoint
 * @package LunixREST\Endpoints
 */
abstract class DoctrineEndpoint extends Endpoint {
    private $entityManager;

    public function setEntityManager(EntityManager $em){
        $this->entityManager = $em;
    }
}
