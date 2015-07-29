<?php
namespace LunixREST\Router;

use LunixREST\Configuration\OutputINIConfiguration;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\UnknownEndPointException;
use LunixREST\Exceptions\UnknownResponseFormatException;
use LunixREST\Request\Request;

class Router {
    protected $request;
    protected $namespace;

    public function __construct($namespace, Request $request){
        $this->namespace = $namespace;
        $this->request = $request;
    }

    public function handle(){
        if(!$this->validateExtension()){
            throw new UnknownResponseFormatException('Unknown response format: ' . $this->request->getExtension());
        }

        $fullEndPoint = '\\' . $this->namespace . '\EndPoints\\' . $this->request->getEndPoint();
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
        $responseData = $endPoint->{$this->request->getMethod()}($this->request->getInstance());

        $responseClass = strtoupper($this->request->getExtension()) . "Response";
        $format = new $responseClass($responseData);
        $format->validate($this->request->getMethod(), $this->request->getEndPoint(), $this->request->getVersion());

        return $format->output();
    }

    private function validateEndpoint()
    {
        //TODO: Properly check the endpoint is something this version can do
        return true;
    }

    private function APIKeyAccessible($apiKey, $endPoint, $method, $instance){
        //TODO: properly check api key access level
        return true;
    }

    private function validateExtension()
    {
        $outputConfig = new OutputINIConfiguration('general');
        $formats = $outputConfig->get('formats');
        return in_array($this->request->getExtension(), $formats);
    }
}