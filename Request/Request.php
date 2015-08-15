<?php
namespace LunixREST\Request;
use LunixREST\Exceptions\InvalidRequestFormatException;

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
     * @var array
     */
    protected $data;
    /**
     * @var string
     */
    protected $ip;

    /**
     * Create a request. Pass Either a URL to parse or the parsed parts.
     * If both are passed the explicitly stated parts will be used.
     * @param $method
     * @param array $headers
     * @param array $data
     * @param $ip
     * @param string|false $url
     * @param string $version
     * @param string $apiKey
     * @param string $endpoint
     * @param string $instance
     * @throws InvalidRequestFormatException
     */
    public function __construct($method, array $headers, array $data, $ip, $url, $version = '', $apiKey = '', $endpoint = '', $instance = ''){
        $this->method = strtolower($method);
        $this->headers = $headers;
        $this->data = $data;
        $this->ip = $ip;

        if($version && $apiKey && $endpoint && $instance){
            $this->version = $version;
            $this->apiKey = $apiKey;
            $this->endpoint = $endpoint;
            $this->instance = $instance;
        } elseif($url) {
            $this->parseURL($url);
        } else {
            throw new InvalidRequestFormatException('Either URL or the rest of the parameters MUST be set');
        }
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $url
     * @throws InvalidRequestFormatException
     */
    private function parseURL($url){
        $splitURL = explode('/', trim($url, '/'));
        if(count($splitURL) < 3){
            throw new InvalidRequestFormatException();
        }
        //Find endpoint
        $this->version = $splitURL[0];
        $this->apiKey = $splitURL[1];
        $this->endpoint = $splitURL[2];

        $splitExtension = explode('.', $splitURL[count($splitURL) - 1]);
        $this->extension = array_pop($splitExtension);

        if(count($splitURL) == 4){
            $this->instance = implode('.', $splitExtension);
        } else {
            $this->endpoint = implode('.', $splitExtension);
            $this->method .= 'All';
        }
    }
}
