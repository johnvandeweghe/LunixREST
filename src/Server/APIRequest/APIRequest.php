<?php
namespace LunixREST\Server\APIRequest;

/**
 * An immutable data class for representing API requests.
 * Class APIRequest
 * @package LunixREST\Server\Request
 */
class APIRequest
{
    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var null|string
     */
    private $element;
    /**
     * @var array
     */
    private $acceptableMIMETypes;
    /**
     * @var null|string
     */
    private $version;
    /**
     * @var null|string
     */
    private $apiKey;
    /**
     * @var array
     */
    private $queryData;
    /**
     * @var null|object|array
     */
    private $data;

    /**
     * APIRequest constructor.
     * @param string $method
     * @param string $endpoint
     * @param null|string $element
     * @param array $acceptableMIMETypes
     * @param null|string $version
     * @param null|string $apiKey
     * @param array $queryData
     * @param null|object|array $data
     */
    public function __construct(
        string $method,
        string $endpoint,
        ?string $element,
        array $acceptableMIMETypes,
        ?string $version,
        ?string $apiKey,
        array $queryData,
        $data
    ) {
        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->element = $element;
        $this->acceptableMIMETypes = $acceptableMIMETypes;
        $this->version = $version;
        $this->apiKey = $apiKey;
        $this->queryData = $queryData;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return null|string
     */
    public function getElement(): ?string
    {
        return $this->element;
    }

    /**
     * @return array
     */
    public function getAcceptableMIMETypes(): array
    {
        return $this->acceptableMIMETypes;
    }

    /**
     * @return null|string
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @return null|string
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * @return array
     */
    public function getQueryData(): array
    {
        return $this->queryData;
    }

    /**
     * @return array|null|object
     */
    public function getData()
    {
        return $this->data;
    }
}
