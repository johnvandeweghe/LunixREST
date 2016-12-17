<?php
namespace LunixREST\Server;

use LunixREST\Endpoint\Endpoint;
use LunixREST\Endpoint\EndpointFactory;
use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Request\Request;
use LunixREST\Response\ResponseData;
use LunixREST\Server\Exceptions\MethodNotFoundException;

/**
 * Class Router
 * @package LunixREST\Router
 */
class Router {
    /**
     * @var EndpointFactory
     */
    private $endpointFactory;

    /**
     * @param EndpointFactory $endpointFactory
     */
    public function __construct(EndpointFactory $endpointFactory){
        $this->endpointFactory = $endpointFactory;
    }

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnknownEndpointException
     * @throws MethodNotFoundException
     */
    public function route(Request $request): ResponseData{
        $endpoint = $this->endpointFactory->getEndpoint($request->getEndpoint(), $request->getVersion());
        return $this->executeEndpoint($endpoint, $request);
    }

    /**
     * @param Endpoint $endpoint
     * @param Request $request
     * @return ResponseData
     * @throws MethodNotFoundException
     */
    protected function executeEndpoint(Endpoint $endpoint, Request $request): ResponseData {
        if(!method_exists($endpoint, $request->getMethod())){
            throw new MethodNotFoundException("The endpoint method " . $request->getMethod() . " was not found");
        }
        return call_user_func([$endpoint, $request->getMethod()], $request);
    }
}
