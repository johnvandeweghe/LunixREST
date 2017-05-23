<?php
namespace LunixREST\Server;

use LunixREST\Server\AccessControl\AccessControl;
use LunixREST\Server\ResponseFactory\ResponseFactory;
use LunixREST\Server\Router\Router;
use LunixREST\Server\Throttle\Throttle;

class GenericRouterGenericServerTest extends GenericServerTest
{
    protected function getMockedRouter(): \PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockBuilder('\LunixREST\Server\Router\GenericRouter')->disableOriginalConstructor()->getMock();
    }

    protected function getServer(
        AccessControl $accessControl,
        Throttle $throttle,
        ResponseFactory $responseFactory,
        Router $router
    ): GenericServer {
        return new GenericRouterGenericServer($accessControl, $throttle, $responseFactory, $router);
    }
}
