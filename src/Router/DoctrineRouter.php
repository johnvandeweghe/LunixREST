<?php
namespace LunixREST\Router;
use LunixREST\AccessControl\AccessControl;
use LunixREST\Throttle\Throttle;
use LunixREST\Configuration\Configuration;
use LunixREST\Request\Request;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineRouter
 * @package LunixREST\Router
 */
class DoctrineRouter extends Router {
    private $entityManager;
    public function __construct(AccessControl $accessControl, Throttle $throttle, Configuration $formatsConfig, $endpointNamespace = '', EntityManager $entityManager){
        parent::__construct($accessControl, $throttle, $formatsConfig, $endpointNamespace);
        $this->entityManager = $entityManager;
    }
    protected function executeEndpoint($fullEndpoint, Request $request){
        $endPoint = new $fullEndpoint($request);

        if($endPoint instanceof DoctrineEndpoint){
            $endPoint->setEntityManager($this->entityManager);
        }

        return call_user_func([$endPoint, $request->getMethod()]);
    }
}
