<?php
namespace LunixREST\Server;

use LunixREST\Server\AccessControl\AccessControl;
use LunixREST\Server\Exceptions\UnableToHandleRequestException;
use LunixREST\Server\ResponseFactory\Exceptions\UnableToCreateAPIResponseException;
use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\APIResponse\APIResponse;
use LunixREST\Server\Exceptions\AccessDeniedException;
use LunixREST\Server\Exceptions\InvalidAPIKeyException;
use LunixREST\Server\Exceptions\ThrottleLimitExceededException;
use LunixREST\Server\ResponseFactory\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Server\ResponseFactory\ResponseFactory;
use LunixREST\Server\Router\Exceptions\UnableToRouteRequestException;
use LunixREST\Server\Router\Router;
use LunixREST\Server\Throttle\Throttle;

/**
 * A Server implementation that derives it's behaviour from an AccessControl, a Throttle, a ResponseFactory, and a Router.
 * Class GenericServer
 * @package LunixREST\Server
 */
class GenericServer implements Server
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
     * @param Router $router
     */
    public function __construct(
        AccessControl $accessControl,
        Throttle $throttle,
        ResponseFactory $responseFactory,
        Router $router
    ) {
        $this->accessControl = $accessControl;
        $this->throttle = $throttle;
        $this->responseFactory = $responseFactory;
        $this->router = $router;
    }

    /**
     * @param APIRequest $request
     * @return APIResponse
     * @throws UnableToHandleRequestException
     * @throws InvalidAPIKeyException
     * @throws ThrottleLimitExceededException
     * @throws NotAcceptableResponseTypeException
     * @throws AccessDeniedException
     * @throws UnableToRouteRequestException
     * @throws UnableToCreateAPIResponseException
     */
    public function handleRequest(APIRequest $request): APIResponse
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
     * @param APIRequest $request
     * @throws InvalidAPIKeyException
     */
    protected function validateKey(APIRequest $request)
    {
        if (!$this->accessControl->validateKey($request->getApiKey())) {
            throw new InvalidAPIKeyException('Invalid API key');
        }
    }

    /**
     * @param APIRequest $request
     * @throws NotAcceptableResponseTypeException
     */
    protected function validateAcceptableMIMETypes(APIRequest $request)
    {
        $supportedFormats = $this->responseFactory->getSupportedMIMETypes();
        $requestedFormats = $request->getAcceptableMIMETypes();

        //Cases that our response factory is capable of responding to
        $requestedFormatSupported = empty($requestedFormats) ||
            in_array('*/*', $requestedFormats) ||
            !empty(array_intersect($requestedFormats, $supportedFormats));

        if (empty($supportedFormats) || !$requestedFormatSupported) {
            throw new NotAcceptableResponseTypeException('None of the requested acceptable response types are supported');
        }
    }
}
