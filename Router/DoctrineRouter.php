<?php
namespace LunixREST\Router;
use LunixREST\AccessControl\AccessControl;
use LunixREST\Throttle\Throttle;
use LunixREST\Configuration\Configuration;
use LunixREST\Request\Request;

/**
 * Class DoctrineRouter
 * @package LunixREST\Router
 */
class DoctrineRouter extends Router {
    private $entitiyManager;
    public function __construct(AccessControl $accessControl, Throttle $throttle, Configuration $formatsConfig, $endpointNamespace = '', EntityManager $entityManager){
        super($accessControl, $throttle, $formatsConfig, $endpointNamespace);
        $this->entityManager = $entityManager;
    }
    private function executeEndpoint($fullEndpoint, Request $request){
        $endPoint = new $fullEndpoint($request);

        if($endPoint instanceof DoctrineEndpoint){
            $endPoint->setEntityManager($this->entitiyManager);
        }

        return call_user_func([$endPoint, $request->getMethod()]);
    }
}
