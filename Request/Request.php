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
     * @param string $version
     * @param string $apiKey
     * @param string $endpoint
     * @param string $extension
     * @param string $instance
     */
    public function __construct($method, array $headers, array $data, $ip, $version, $apiKey, $endpoint, $extension, $instance = null){
        $this->method = strtolower($method);
        $this->headers = $headers;
        $this->data = $data;
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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method . ($this->instance ? '' : 'All');
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
     * @param $method
     * @param array $headers
     * @param array $data
     * @param $ip
     * @param string $url
     * @return Request
     * @throws InvalidRequestFormatException
     */
    public static function createFromURL($method, array $headers, array $data, $ip, $url){
        $splitURL = explode('/', trim($url, '/'));
        if(count($splitURL) < 3){
            throw new InvalidRequestFormatException();
        }
        //Find endpoint
        $version = $splitURL[0];
        $apiKey = $splitURL[1];
        $endpoint = $splitURL[2];

        $splitExtension = explode('.', $splitURL[count($splitURL) - 1]);
        $extension = array_pop($splitExtension);

        $instance = null;

        if(count($splitURL) == 4){
            $instance = implode('.', $splitExtension);
        } else {
            $endpoint = implode('.', $splitExtension);
        }


        return new Request($method, $headers, $data, $ip, $version, $apiKey, $endpoint, $extension, $instance);
    }
}
