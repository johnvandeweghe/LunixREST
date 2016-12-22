<?php
namespace LunixREST\APIRequest\URLParser;

class ParsedURL
{
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var null|string
     */
    private $element;
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
    private $acceptableMIMETypes;
    /**
     * @var null|string
     */
    private $queryString;

    /**
     * ParsedURL constructor.
     * @param string $endpoint
     * @param null|string $element
     * @param null|string $version
     * @param null|string $apiKey
     * @param array $acceptableMIMETypes
     * @param null|string $queryString
     */
    public function __construct(string $endpoint, ?string $element, ?string $version, ?string $apiKey, array $acceptableMIMETypes, ?string $queryString)
    {
        $this->endpoint = $endpoint;
        $this->element = $element;
        $this->version = $version;
        $this->apiKey = $apiKey;
        $this->acceptableMIMETypes = $acceptableMIMETypes;
        $this->queryString = $queryString;
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
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @return null|string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return null|string
     */
    public function getApiKey()
    {
        return $this->apiKey;
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
    public function getQueryString()
    {
        return $this->queryString;
    }
}
