<?php
namespace LunixREST\Server;

use LunixREST\AccessControl\AccessControl;
use LunixREST\Endpoint\EndpointFactory;
use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidAPIKeyException;
use LunixREST\Exceptions\MethodNotFoundException;
use LunixREST\Exceptions\ThrottleLimitExceededException;
use LunixREST\Request\Request;
use LunixREST\Response\Exceptions\UnknownResponseTypeException;
use LunixREST\Response\Response;
use LunixREST\Response\ResponseFactory;
use LunixREST\Throttle\Throttle;

class Server {
    /**
     * @var AccessControl
     */
    protected $accessControl;
    /**
     * @var Throttle
     */
    protected $throttle;
    /**
     * @var ResponseFactory
     */
    protected $responseFactory;
    /**
     * @var Router
     */
    private $router;

    /**
     * @param AccessControl $accessControl
     * @param Throttle $throttle
     * @param ResponseFactory $responseFactory
     * @param EndpointFactory $endpointFactory
     */
    public function __construct(AccessControl $accessControl, Throttle $throttle, ResponseFactory $responseFactory, EndpointFactory $endpointFactory){
        $this->accessControl = $accessControl;
        $this->throttle = $throttle;
        $this->responseFactory = $responseFactory;
        $this->router = new Router($endpointFactory);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws AccessDeniedException
     * @throws ThrottleLimitExceededException
     * @throws UnknownEndpointException
     * @throws MethodNotFoundException
     */
    public function handleRequest(Request $request): Response {
        $this->validateKey($request);

        $this->validateExtension($request);

        if($this->throttle->shouldThrottle($request)) {
            throw new ThrottleLimitExceededException('Request limit exceeded');
        }

        if(!$this->accessControl->validateAccess($request)) {
            throw new AccessDeniedException("API key does not have the required permissions to access requested resource");
        }

        $this->throttle->logRequest($request);

        $responseData = $this->router->route($request);

        return $this->responseFactory->getResponse($responseData, $request->getExtension());
    }

    /**
     * @param Request $request
     * @throws InvalidAPIKeyException
     */
    protected function validateKey(Request $request){
        if(!$this->accessControl->validateKey($request->getApiKey())){
            throw new InvalidAPIKeyException('Invalid API key');
        }
    }

    /**
     * @param Request $request
     * @throws UnknownResponseTypeException
     */
    protected function validateExtension(Request $request) {
        $formats = $this->responseFactory->getSupportedTypes();
        if(empty($formats) || !in_array($request->getExtension(), $formats)){
            throw new UnknownResponseTypeException('Unknown response format: ' . $request->getExtension());
        }
    }
}
