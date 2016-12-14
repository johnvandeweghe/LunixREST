<?php
namespace LunixREST\Request\HeaderParser;

class ParsedHeaders {
    /**
     * @var array
     */
    private $acceptableMIMETypes;
    private $APIKey;
    private $contentType;

    /**
     * ParsedHeader constructor.
     * @param $contentType
     * @param array $acceptableMIMETypes
     * @param $APIKey
     */
    public function __construct($contentType, array $acceptableMIMETypes, $APIKey) {
        $this->contentType = $contentType;
        $this->acceptableMIMETypes = $acceptableMIMETypes;
        $this->APIKey = $APIKey;
    }

    public function getContentType() {
        return $this->contentType;
    }

    public function getAcceptableMIMETypes(): array {
        return $this->acceptableMIMETypes;
    }

    public function getAPIKey() {
        return $this->APIKey;
    }
}
