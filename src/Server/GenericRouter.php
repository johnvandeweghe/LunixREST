<?php
namespace LunixREST\Server;

use LunixREST\Endpoint\Endpoint;
use LunixREST\APIRequest\APIRequest;
use LunixREST\Endpoint\EndpointFactory;
use LunixREST\Server\Exceptions\MethodNotFoundException;

/**
 * Class GenericRouter
 * @package LunixREST\Server
 */
class GenericRouter implements Router
{
    /**
     * @var EndpointFactory
     */
    private $endpointFactory;

    /**
     * DefaultRouter constructor.
     * @param EndpointFactory $endpointFactory
     */
    public function __construct(EndpointFactory $endpointFactory)
    {
        $this->endpointFactory = $endpointFactory;
    }

    /**
     * @param APIRequest $request
     * @return null|object|array
     * @throws MethodNotFoundException
     */
    public function route(APIRequest $request)
    {
        $endpoint = $this->endpointFactory->getEndpoint($request->getEndpoint(), $request->getVersion());
        return $this->executeEndpoint($endpoint, $request);
    }

    /**
     * @param Endpoint $endpoint
     * @param APIRequest $request
     * @return null|object|array
     * @throws MethodNotFoundException
     */
    protected function executeEndpoint(Endpoint $endpoint, APIRequest $request)
    {
        $method = $this->mapEndpointMethod($request);
        if (!method_exists($endpoint, $method)) {
            throw new MethodNotFoundException("The endpoint method " . $method . " was not found");
        }
        return call_user_func([$endpoint, $method], $request);
    }

    protected function mapEndpointMethod(APIRequest $request): string
    {
        return strtolower($request->getMethod()) . (!$request->getElement() ? 'All': '');
    }
}
