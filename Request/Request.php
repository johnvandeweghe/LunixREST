<?php
namespace LunixREST\Request;
use LunixREST\Exceptions\InvalidRequestFormatException;

class Request {
    protected $method;
    protected $headers;
    protected $version;
    protected $apiKey;
    protected $endPoint;
    protected $instance;
    protected $extension;
    protected $data;

    public function __construct($method, array $headers, $url, $data){
        $this->method = $method;

        $splitURL = explode('/', $url);
        if(count($splitURL) < 3){
            throw new InvalidRequestFormatException();
        }
        //Find endpoint
        $this->version = $splitURL[0];
        $this->apiKey = $splitURL[1];
        $this->endPoint = $splitURL[2];

        if(count($splitURL) == 4){
            $splitExtension = explode('.', $splitURL[count($splitURL) - 1]);
            $this->extension = array_pop($splitExtension);
            $this->instance = implode('.', $splitExtension);
        }

        $this->headers = $headers;
        $this->data = $data;
    }

    /**
     * @return mixed
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
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return mixed
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
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
