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
    protected $extension;
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
     * @var MIMEProvider
     */
    private $MIMEProvider;

    /**
     * Create a request. Pass Either a URL to parse or the parsed parts.
     * If both are passed the explicitly stated parts will be used.
     * @param MIMEProvider $MIMEProvider
     * @param $method
     * @param array $headers
     * @param RequestData $body
     * @param RequestData $urlData
     * @param $ip
     * @param string $version
     * @param string $apiKey
     * @param string $endpoint
     * @param string $extension
     * @param string $instance
     */

    public function __construct(MIMEProvider $MIMEProvider, $method, array $headers, RequestData $body, RequestData $urlData, $ip, $version, $apiKey, $endpoint, $extension, $instance = null){
        $this->MIMEProvider = $MIMEProvider;
        $this->method = strtolower($method);
        $this->headers = $headers;
        $this->body = $body;
        $this->urlData = $urlData;
        $this->ip = $ip;
        $this->version = $version;
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
        $this->extension = $extension;
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
     * @return string
     */
    public function getInstance() {
        return $this->instance;
    }

    /**
     * @return string
     */
    public function getExtension() {
        return $this->extension;
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

    //TODO: Unit test
    public function getAcceptableMIMETypes(): array {
        $acceptedMIMETypes = [];
        if($this->extension) {
            //extension to mime type conversion
            $acceptedMIMETypes[] = $this->MIMEProvider->getByFileExtension($this->extension);
        } else {
            //TODO: follow RFC2616 order
            $headerAccepts = [];
            foreach($this->headers as $key => $value) {
                if(strtolower($key) == 'http_accept'){
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
    }

}
