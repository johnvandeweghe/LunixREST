<?php
namespace LunixREST\Router;

use LunixREST\AccessControl\AccessControl;
use LunixREST\Configuration\Configuration;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidAPIKeyException;
use LunixREST\Exceptions\InvalidResponseFormatException;
use LunixREST\Exceptions\ThrottleLimitExceededException;
use LunixREST\Exceptions\UnknownEndPointException;
use LunixREST\Exceptions\UnknownResponseFormatException;
use LunixREST\Request\Request;
use LunixREST\Throttle\Throttle;

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
    protected $endPointNamespace;

    /**
     * @param AccessControl $accessControl
     * @param Throttle $throttle
     * @param Configuration $outputConfig
     * @param Configuration $formatsConfig
     * @param string $endPointNamespace
     */
    public function __construct(AccessControl $accessControl, Throttle $throttle, Configuration $outputConfig, Configuration $formatsConfig, $endPointNamespace = ''){
        $this->accessControl = $accessControl;
        $this->throttle = $throttle;
        $this->outputConfig = $outputConfig;
        $this->formatsConfig = $formatsConfig;
        $this->endPointNamespace = $endPointNamespace;
    }

    /**
     * @param Request $request
     * @return string
     * @throws AccessDeniedException
     * @throws InvalidAPIKeyException
     * @throws InvalidResponseFormatException
     * @throws ThrottleLimitExceededException
     * @throws UnknownEndPointException
     * @throws UnknownResponseFormatException
     */
    public function handle(Request $request){
        if(!$this->accessControl->validateKey($request->getApiKey())){
            throw new InvalidAPIKeyException('Invalid API key');
        }

        if(!$this->validateExtension($request)){
            throw new UnknownResponseFormatException('Unknown response format: ' .$request->getExtension());
        }

        $fullEndPoint = '\\' . $this->endPointNamespace . '\EndPoints\\' . $request->getEndPoint();
        if(!class_exists($fullEndPoint) || !is_subclass_of($fullEndPoint, '\LunixREST\EndPoints\EndPoint')){
            throw new UnknownEndPointException("unknown endpoint: " . $fullEndPoint);
        }

        if(!$this->validateEndpoint($request)){
            throw new UnknownEndPointException("unknown endpoint: " . $fullEndPoint);
        }

        if($this->throttle->throttle($request->getApiKey(), $request->getEndPoint(), $request->getMethod(), $request->getIp())){
            throw new ThrottleLimitExceededException('Request limit exceeded');
        }

        if(!$this->accessControl->validateAccess($request->getApiKey(), $request->getEndPoint(), $request->getMethod(), $request->getInstance())){
            throw new AccessDeniedException("API key does not have the required permissions to access requested resource");
        }

        $endPoint = new $fullEndPoint($request);
        if($request->getInstance()) {
            $args = [$request->getInstance(), $request->getData()];
        } else {
            $args = [$request->getData()];
        }
        $responseData = call_user_func_array([$endPoint, $request->getMethod()], $args);

        if(!is_array($responseData)){
            throw new InvalidResponseFormatException('Method output MUST be an array');
        }

        $responseClass = '\\LunixREST\\Response\\' . strtoupper($request->getExtension()) . "Response";
        $format = new $responseClass($responseData);
        if(!$format->validate($this->outputConfig, $request->getMethod(), $request->getEndPoint(), $request->getVersion())){
            throw new InvalidResponseFormatException('Method output did not match defined output format');
        }

        return $format->output();
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function validateEndpoint(Request $request)
    {
        $formats = $this->formatsConfig->get('endpoints_' . str_replace('.', '_', $request->getVersion()));
        return $formats && in_array($request->getEndpoint(), $formats);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function validateExtension(Request $request)
    {
        $formats = $this->formatsConfig->get('formats');
        return $formats && in_array($request->getExtension(), $formats);
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
     * @param Configuration $outputConfig
     */
    public function setOutputConfig(Configuration $outputConfig)
    {
        $this->outputConfig = $outputConfig;
    }

    /**
     * @param Configuration $formatsConfig
     */
    public function setFormatsConfig(Configuration $formatsConfig)
    {
        $this->formatsConfig = $formatsConfig;
    }

    /**
     * @param string $endPointNamespace
     */
    public function setEndPointNamespace($endPointNamespace)
    {
        $this->endPointNamespace = $endPointNamespace;
    }
}
