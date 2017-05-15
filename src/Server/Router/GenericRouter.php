<?php
namespace LunixREST\Server\Router;

use LunixREST\Server\Router\Endpoint\Endpoint;
use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\Router\EndpointFactory\EndpointFactory;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\Router\Exceptions\MethodNotFoundException;

/**
 * An implementation of a Router that uses an EndpointFactory to find an Endpoint. Maps methods based on the get/getAll pattern.
 * Class GenericRouter
 * @package LunixREST\Server\Router
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
     * @return APIResponseData
     * @throws MethodNotFoundException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    public function route(APIRequest $request): APIResponseData
    {
        $endpoint = $this->endpointFactory->getEndpoint($request->getEndpoint(), $request->getVersion());
        return $this->executeEndpoint($endpoint, $request);
    }

    /**
     * @param Endpoint $endpoint
     * @param APIRequest $request
     * @return APIResponseData
     * @throws MethodNotFoundException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     */
    protected function executeEndpoint(Endpoint $endpoint, APIRequest $request): APIResponseData
    {
        $method = $this->mapEndpointMethod($request);
        if (!method_exists($endpoint, $method)) {
            throw new MethodNotFoundException("The endpoint method " . $method . " was not found");
        }
        return call_user_func([$endpoint, $method], $request);
    }

    /**
     * @param APIRequest $request
     * @return string
     */
    protected function mapEndpointMethod(APIRequest $request): string
    {
        return strtolower($request->getMethod()) . (!$request->getElement() ? 'All': '');
    }
}
