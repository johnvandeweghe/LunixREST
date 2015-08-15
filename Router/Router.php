<?php
namespace LunixREST\Router;

use LunixREST\AccessControl\AccessControl;
use LunixREST\Configuration\Configuration;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidAPIKeyException;
use LunixREST\Exceptions\InvalidResponseFormatException;
use LunixREST\Exceptions\ThrottleLimitExceededException;
use LunixREST\Exceptions\UnknownEndpointException;
use LunixREST\Exceptions\UnknownResponseFormatException;
use LunixREST\Request\Request;
use LunixREST\Throttle\Throttle;
use ReflectionClass;

/**
 * Class Router
 * @package LunixREST\Router
 */
class Router {
    /**
     * @var AccessControl
     */
    protected $accessControl;
    /**
     * @var Throttle
     */
    protected $throttle;
    /**
     * @var Configuration
     */
    protected $outputConfig;
    /**
     * @var Configuration
     */
    protected $formatsConfig;
    /**
     * @var string
     */
    protected $endpointNamespace;

    /**
     * @param AccessControl $accessControl
     * @param Throttle $throttle
     * @param Configuration $formatsConfig
     * @param string $endpointNamespace
     */
    public function __construct(AccessControl $accessControl, Throttle $throttle, Configuration $formatsConfig, $endpointNamespace = ''){
        $this->accessControl = $accessControl;
        $this->throttle = $throttle;
        $this->formatsConfig = $formatsConfig;
        $this->endpointNamespace = $endpointNamespace;
    }

    /**
     * @param Request $request
     * @return string
     * @throws AccessDeniedException
     * @throws InvalidAPIKeyException
     * @throws InvalidResponseFormatException
     * @throws ThrottleLimitExceededException
     * @throws UnknownEndpointException
     * @throws UnknownResponseFormatException
     */
    public function handle(Request $request){
        $this->validateKey($request);

        $this->validateExtension($request);

        $fullEndpoint = $this->endpointClass($request);

        $this->validateEndpoint($fullEndpoint);

        $this->throttle($request);

        $this->validateAccess($request);

        $endPoint = new $fullEndpoint($request);
        $responseData = call_user_func([$endPoint, $request->getMethod()]);

        $this->validateResponse($responseData);

        $responseClass = $this->responseClass($request);
        $format = new $responseClass($responseData);

        return $format->output();
    }

    /**
     * @param Request $request
     * @return string
     */
    private function endpointClass(Request $request){
        return '\\' . $this->endpointNamespace . '\Endpoints\v' . str_replace('.', '_', $request->getVersion()) . '\\' . $request->getEndpoint();
    }

    /**
     * @param Request $request
     * @return string
     */
    private function responseClass(Request $request){
        return '\\LunixREST\\Response\\' . strtoupper($request->getExtension()) . "Response";
    }

    /**
     * @param Request $request
     * @throws InvalidAPIKeyException
     */
    private function validateKey(Request $request){
        if(!$this->accessControl->validateKey($request->getApiKey())){
            throw new InvalidAPIKeyException('Invalid API key');
        }
    }

    /**
     * @param Request $request
     * @return bool
     * @throws UnknownResponseFormatException
     */
    private function validateExtension(Request $request)
    {
        $formats = $this->formatsConfig->get('formats');
        if(!($formats && in_array($request->getExtension(), $formats))){
            throw new UnknownResponseFormatException('Unknown response format: ' .$request->getExtension());
        }
    }

    /**
     * @param $fullEndpoint
     * @throws UnknownEndpointException
     */
    private function validateEndpoint($fullEndpoint){
        $endpointReflection = new \ReflectionClass($fullEndpoint);
        if(!class_exists($fullEndpoint) || !$endpointReflection->isSubclassOf('\LunixREST\Endpoints\Endpoint')){
            throw new UnknownEndpointException("unknown endpoint: " . $fullEndpoint);
        }
    }

    /**
     * @param Request $request
     * @throws ThrottleLimitExceededException
     */
    private function throttle(Request $request){
        if($this->throttle->throttle($request)){
            throw new ThrottleLimitExceededException('Request limit exceeded');
        }
    }

    /**
     * @param Request $request
     * @throws AccessDeniedException
     */
    private function validateAccess(Request $request){
        if(!$this->accessControl->validateAccess($request)){
            throw new AccessDeniedException("API key does not have the required permissions to access requested resource");
        }
    }

    /**
     * @param $responseData
     * @throws InvalidResponseFormatException
     */
    private function validateResponse($responseData){
        if(!is_array($responseData)){
            throw new InvalidResponseFormatException('Method output MUST be an array');
        }
    }

    /**
     * @param AccessControl $accessControl
     */
    public function setAccessControl(AccessControl $accessControl)
    {
        $this->accessControl = $accessControl;
    }

    /**
     * @param Throttle $throttle
     */
    public function setThrottle(Throttle $throttle)
    {
        $this->throttle = $throttle;
    }

    /**
     * @param Configuration $formatsConfig
     */
    public function setFormatsConfig(Configuration $formatsConfig)
    {
        $this->formatsConfig = $formatsConfig;
    }

    /**
     * @param string $endpointNamespace
     */
    public function setEndpointNamespace($endpointNamespace)
    {
        $this->endpointNamespace = $endpointNamespace;
    }
}
