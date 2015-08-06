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
     * @param $method
     * @param array $headers
     * @param $url
     * @param $data
     * @throws InvalidRequestFormatException
     */
    public function __construct($method, array $headers, $url, array $data){
        $this->method = strtolower($method);

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

        $this->headers = $headers;
        $this->data = $data;
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
}
