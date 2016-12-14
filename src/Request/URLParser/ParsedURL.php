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
     * @var array
     */
    protected $acceptableMIMETypes;
    /**
     * @var string
     */
    protected $instance;

    /**
     * ParsedURL constructor.
     * @param RequestData $requestData
     * @param string $version
     * @param string|null $apiKey
     * @param string $endpoint
     * @param array $acceptableMIMETypes
     * @param string|null $instance
     */
    public function __construct(RequestData $requestData, $version, $apiKey, $endpoint, $acceptableMIMETypes, $instance) {
        $this->requestData = $requestData;
        $this->version = $version;
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
        $this->acceptableMIMETypes = $acceptableMIMETypes;
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
    public function getAPIKey() {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string {
        return $this->endpoint;
    }

    /**
     * @return array
     */
    public function getAcceptableMIMETypes(): array {
        return $this->acceptableMIMETypes;
    }

    /**
     * @return string|null
     */
    public function getInstance() {
        return $this->instance;
    }
}
