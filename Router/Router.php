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
    protected $request;
    protected $endPointNamespace;
    protected $accessControl;
    protected $outputConfig;
    protected $formatsConfig;

    public function __construct(Request $request, AccessControl $accessControl,  Configuration $outputConfig, Configuration $formatsConfig, $endPointNamespace = ''){
        $this->endPointNamespace = $endPointNamespace;
        $this->request = $request;
        $this->accessControl = $accessControl;
        $this->outputConfig = $outputConfig;
        $this->formatsConfig = $formatsConfig;
    }

    public function handle(){
        if(!$this->validateExtension()){
            throw new UnknownResponseFormatException('Unknown response format: ' . $this->request->getExtension());
        }

        $fullEndPoint = '\\' . $this->endPointNamespace . '\EndPoints\\' . $this->request->getEndPoint();
        if(!class_exists($fullEndPoint)){
            throw new UnknownEndPointException("unknown endpoint: " . $fullEndPoint);
        }

        if(!$this->validateEndpoint()){
            throw new UnknownEndPointException("unknown endpoint: " . $fullEndPoint);
        }

        if(!$this->APIKeyAccessible($this->request->getApiKey(), $this->request->getEndPoint(), $this->request->getMethod(), $this->request->getInstance())){
            throw new AccessDeniedException("API key does not have the required permissions to access requested resource");
        }

        $endPoint = new $fullEndPoint($this->request);
        $responseData = $endPoint->{$this->request->getMethod()}($this->request->getInstance(), $this->request->getData());

        $responseClass = '\\LunixREST\\Response\\' . strtoupper($this->request->getExtension()) . "Response";
        $format = new $responseClass($responseData);
        if(!$format->validate($this->outputConfig, $this->request->getMethod(), $this->request->getEndPoint(), $this->request->getVersion())){
            throw new InvalidResponseFormatException('Method output did not match defined output format');
        }

        return $format->output();
    }

    private function validateEndpoint()
    {
        $formats = $this->formatsConfig->get('endpoints_' . str_replace('.', '_', $this->request->getVersion()));
        return $formats && in_array($this->request->getEndpoint(), $formats);
    }

    private function APIKeyAccessible($apiKey, $endPoint, $method, $instance){
        return $this->accessControl->validate($apiKey, $endPoint, $method, $instance);
    }

    private function validateExtension()
    {
        $formats = $this->formatsConfig->get('formats');
        return $formats && in_array($this->request->getExtension(), $formats);
    }
}
