<?php
namespace LunixREST\RequestFactory\HeaderParser;

/**
 * This object represents the data pulled from headers for an APIRequest.
 * Class ParsedHeaders
 * @package LunixREST\RequestFactory\HeaderParser
 */
class ParsedHeaders
{
    /**
     * @var array
     */
    private $acceptableMIMETypes;
    /**
     * @var
     */
    private $APIKey;
    /**
     * @var
     */
    private $contentType;

    /**
     * ParsedHeader constructor.
     * @param $contentType
     * @param array $acceptableMIMETypes
     * @param $APIKey
     */
    public function __construct($contentType, array $acceptableMIMETypes, $APIKey)
    {
        $this->contentType = $contentType;
        $this->acceptableMIMETypes = $acceptableMIMETypes;
        $this->APIKey = $APIKey;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return array
     */
    public function getAcceptableMIMETypes(): array
    {
        return $this->acceptableMIMETypes;
    }

    /**
     * @return mixed
     */
    public function getAPIKey()
    {
        return $this->APIKey;
    }
}
