<?php
namespace LunixREST\Server;

use LunixREST\AccessControl\AccessControl;
use LunixREST\Endpoint\EndpointFactory;
use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidAPIKeyException;
use LunixREST\Exceptions\ThrottleLimitExceededException;
use LunixREST\Request\Request;
use LunixREST\Response\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Response\Response;
use LunixREST\Response\ResponseFactory;
use LunixREST\Server\Exceptions\MethodNotFoundException;
use LunixREST\Throttle\Throttle;

//TODO: Unit test
class Server
{
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
    public function __construct(
        AccessControl $accessControl,
        Throttle $throttle,
        ResponseFactory $responseFactory,
        EndpointFactory $endpointFactory
    ) {
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
     * @throws NotAcceptableResponseTypeException
     */
    public function handleRequest(Request $request): Response
    {
        $this->validateKey($request);

        if ($this->throttle->shouldThrottle($request)) {
            throw new ThrottleLimitExceededException('Request limit exceeded');
        }

        $this->validateAcceptableMIMETypes($request);

        if (!$this->accessControl->validateAccess($request)) {
            throw new AccessDeniedException("API key does not have the required permissions to access requested resource");
        }

        $this->throttle->logRequest($request);

        $responseData = $this->router->route($request);

        return $this->responseFactory->getResponse($responseData, $request->getAcceptableMIMETypes());
    }

    /**
     * @param Request $request
     * @throws InvalidAPIKeyException
     */
    protected function validateKey(Request $request)
    {
        if (!$this->accessControl->validateKey($request->getApiKey())) {
            throw new InvalidAPIKeyException('Invalid API key');
        }
    }

    /**
     * @param Request $request
     * @throws NotAcceptableResponseTypeException
     */
    //TODO: Handle wildcards in request MIME types (*/*)
    protected function validateAcceptableMIMETypes(Request $request)
    {
        $formats = $this->responseFactory->getSupportedMIMETypes();
        if (empty($formats) || (
                !empty($request->getAcceptableMIMETypes()) && empty(array_intersect($request->getAcceptableMIMETypes(),
                    $formats))
            )
        ) {
            throw new NotAcceptableResponseTypeException('None of the requests acceptable response types are valid');
        }
    }
}
