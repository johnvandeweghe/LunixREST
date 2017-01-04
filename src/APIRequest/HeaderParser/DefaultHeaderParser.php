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

        foreach ($headers as $key => $values) {
            if (strtolower($key) == 'http-accept') {
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
        foreach ($headers as $key => $values) {
            if (strtolower($key) == strtolower($this->apiKeyHeaderKey)) {
                foreach($values as $value) {
                    return $value;
                }
            }
        }
        return null;
    }

    protected function getContentType(array $headers)
    {
        foreach ($headers as $key => $values) {
            if (strtolower($key) == 'content-type') {
                foreach ($values as $value) {
                    return $value;
                }
            }
        }
        return null;
    }
}
