<?php
namespace LunixREST\Request\URLParser;

use LunixREST\Request\RequestData\RequestData;

class ParsedURL {
    /**
     * @var RequestData
     */
    protected $requestData;
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
    protected $extension;
    /**
     * @var string
     */
    protected $instance;

    /**
     * ParsedURL constructor.
     * @param RequestData $requestData
     * @param string $version
     * @param string $apiKey
     * @param string $endpoint
     * @param string $extension
     * @param string $instance
     */
    public function __construct(RequestData $requestData, $version, $apiKey, $endpoint, $extension, $instance) {
        $this->requestData = $requestData;
        $this->version = $version;
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
        $this->extension = $extension;
        $this->instance = $instance;
    }

    /**
     * @return RequestData
     */
    public function getRequestData(): RequestData {
        return $this->requestData;
    }

    /**
     * @return string
     */
    public function getVersion(): string {
        return $this->version;
    }

    /**
     * @return string|null
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string {
        return $this->endpoint;
    }

    /**
     * @return string|null
     */
    public function getExtension() {
        return $this->extension;
    }

    /**
     * @return string|null
     */
    public function getInstance() {
        return $this->instance;
    }
}
