<?php
namespace LunixREST\Request;
use LunixREST\Request\RequestData\RequestData;

/**
 * Class Request
 * @package LunixREST\Request
 */
class Request {
    /**
     * @var string
     */
    protected $method;
    /**
     * @var array
     */
    protected $headers;
    /**
     * @var string
     */
    protected $version;
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var string
     */
    protected $endpoint;
    /**
     * @var string
     */
    protected $instance;
    /**
     * @var string
     */
    protected $ip;
    /**
     * @var RequestData
     */
    private $body;
    /**
     * @var RequestData
     */
    private $urlData;
    /**
     * @var array
     */
    private $acceptableMIMETypes;

    /**
     * Create a request. Pass Either a URL to parse or the parsed parts.
     * If both are passed the explicitly stated parts will be used.
     * @param $method
     * @param array $headers
     * @param RequestData $body
     * @param RequestData $urlData
     * @param $ip
     * @param string $version
     * @param string $apiKey
     * @param string $endpoint
     * @param array $acceptableMIMETypes
     * @param string $instance
     * @internal param string $extension
     */

    public function __construct($method, array $headers, RequestData $body, RequestData $urlData, $ip, $version, $apiKey, $endpoint, array $acceptableMIMETypes = [], $instance = null){
        $this->method = strtolower($method);
        $this->headers = $headers;
        $this->body = $body;
        $this->urlData = $urlData;
        $this->ip = $ip;
        $this->version = $version;
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
        $this->acceptableMIMETypes = $acceptableMIMETypes;
        $this->instance = $instance;
    }

    /**
     * @return string
     */
    public function getIp() {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->method . ($this->instance ? '' : 'All');
    }

    /**
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getEndpoint() {
        return $this->endpoint;
    }

    /**
     * @return array
     */
    public function getAcceptableMIMETypes(): array {
        return $this->acceptableMIMETypes;
    }

    /**
     * @return string
     */
    public function getInstance() {
        return $this->instance;
    }
    /**
     * @return RequestData
     */
    public function getBody(): RequestData {
        return $this->body;
    }

    /**
     * @return RequestData
     */
    public function getUrlData(): RequestData {
        return $this->urlData;
    }

    /*
     *
        $acceptedMIMETypes = [];
        if($this->extension) {
            //extension to mime type conversion
            $acceptedMIMETypes[] = $this->MIMEProvider->getByFileExtension($this->extension);
        } else {
            $headerAccepts = [];
            foreach($this->headers as $key => $value) {
                if(strtolower($key) == 'http-accept'){
                    $values = explode(',', $value);
                    foreach($values as $acceptedType) {
                        $typeParts = explode(';', $acceptedType);
                        if(count($typeParts) > 0 ){
                            $headerAccepts[] = trim($typeParts);
                        }
                    }
                    break;
                }
            }
            $acceptedMIMETypes = array_merge($acceptedMIMETypes, $headerAccepts);
        }

        return $acceptedMIMETypes;
     */
}
