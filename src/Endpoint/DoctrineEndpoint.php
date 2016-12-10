<?php
namespace LunixREST\Endpoint;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineEndpoint
 * @package LunixREST\Endpoints
 */
class DoctrineEndpoint extends DefaultEndpoint {
    protected $entityManager;

    public function __construct(EntityManager $em){
        $this->entityManager = $em;
    }
}
