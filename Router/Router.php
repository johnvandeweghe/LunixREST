<?php
namespace LunixREST\Router;

use LunixREST\AccessControl\AccessControl;
use LunixREST\Configuration\Configuration;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidResponseFormatException;
use LunixREST\Exceptions\UnknownEndPointException;
use LunixREST\Exceptions\UnknownResponseFormatException;
use LunixREST\Request\Request;

class Router {
    protected $endPointNamespace;
    protected $accessControl;
    protected $outputConfig;
    protected $formatsConfig;

    public function __construct(AccessControl $accessControl,  Configuration $outputConfig, Configuration $formatsConfig, $endPointNamespace = ''){
        $this->endPointNamespace = $endPointNamespace;
        $this->accessControl = $accessControl;
        $this->outputConfig = $outputConfig;
        $this->formatsConfig = $formatsConfig;
    }

    public function handle(Request $request){
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

        if(!$this->APIKeyAccessible($request->getApiKey(), $request->getEndPoint(), $request->getMethod(), $request->getInstance())){
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

    private function validateEndpoint(Request $request)
    {
        $formats = $this->formatsConfig->get('endpoints_' . str_replace('.', '_', $request->getVersion()));
        return $formats && in_array($request->getEndpoint(), $formats);
    }

    private function APIKeyAccessible($apiKey, $endPoint, $method, $instance){
        return $this->accessControl->validate($apiKey, $endPoint, $method, $instance);
    }

    private function validateExtension(Request $request)
    {
        $formats = $this->formatsConfig->get('formats');
        return $formats && in_array($request->getExtension(), $formats);
    }
}
