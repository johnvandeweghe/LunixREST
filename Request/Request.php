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
    protected $endPoint;
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
     * Create a request. Pass Either a URL to parse or the parsed parts.
     * If both are passed the explicitly stated parts will be used.
     * @param $method
     * @param array $headers
     * @param array $data
     * @param $ip
     * @param string|false $url
     * @param string $version
     * @param string $apiKey
     * @param string $endPoint
     * @param string $instance
     * @throws InvalidRequestFormatException
     */
    public function __construct($method, array $headers, array $data, $ip, $url, $version = '', $apiKey = '', $endPoint = '', $instance = ''){
        $this->method = strtolower($method);
        $this->headers = $headers;
        $this->data = $data;
        $this->ip = $ip;

        if($version && $apiKey && $endPoint && $instance){
            $this->version = $version;
            $this->apiKey = $apiKey;
            $this->endPoint = $endPoint;
            $this->instance = $instance;
        } else {
            if(!$url){
                throw new InvalidRequestFormatException('Either URL or the rest of the parameters MUST be set');
            } else {
                $this->parseURL($url);
            }
        }
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
    public function getEndPoint()
    {
        return $this->endPoint;
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
     * @param $url
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
        $this->endPoint = $splitURL[2];

        $splitExtension = explode('.', $splitURL[count($splitURL) - 1]);
        $this->extension = array_pop($splitExtension);

        if(count($splitURL) == 4){
            $this->instance = implode('.', $splitExtension);
        } else {
            $this->endPoint = implode('.', $splitExtension);
            $this->method .= 'All';
        }
    }
}
