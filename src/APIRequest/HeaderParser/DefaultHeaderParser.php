<?php
namespace LunixREST\APIRequest\HeaderParser;

class DefaultHeaderParser implements HeaderParser
{

    private $apiKeyHeaderKey;

    /**
     * DefaultHeaderParser constructor.
     * @param string $apiKeyHeaderKey
     */
    public function __construct($apiKeyHeaderKey = 'x-api-key')
    {
        $this->apiKeyHeaderKey = $apiKeyHeaderKey;
    }

    public function parse(array $headers): ParsedHeaders
    {
        $contentType = $this->getContentType($headers);
        $acceptableMIMETypes = $this->findAcceptableMIMETypes($headers);
        $apiKey = $this->findAPIKey($headers);

        return new ParsedHeaders($contentType, $acceptableMIMETypes, $apiKey);
    }

    protected function findAcceptableMIMETypes(array $headers): array
    {
        //TODO: follow RFC2616 order
        $acceptedMIMETypes = [];

        //TODO: Headers are now in format key => values[], this won't work
        foreach ($headers as $key => $value) {
            if (strtolower($key) == 'http-accept') {
                $values = explode(',', $value);
                foreach ($values as $acceptedType) {
                    $typeParts = explode(';', $acceptedType);
                    if (count($typeParts) > 0) {
                        $acceptedMIMETypes[] = trim($typeParts[0]);
                    }
                }
                break;
            }
        }
        return $acceptedMIMETypes;
    }

    protected function findAPIKey(array $headers)
    {
        //TODO: Headers are now in format key => values[], this won't work
        foreach ($headers as $key => $value) {
            if (strtolower($key) == strtolower($this->apiKeyHeaderKey)) {
                return $value;
            }
        }
        return null;
    }

    protected function getContentType(array $headers)
    {
        //TODO: Headers are now in format key => values[], this won't work
        foreach ($headers as $key => $value) {
            if (strtolower($key) == 'content-type') {
                return $value;
            }
        }
        return null;
    }
}
