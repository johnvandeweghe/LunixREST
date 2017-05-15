<?php
namespace LunixREST\RequestFactory\HeaderParser;

/**
 * Parse out all the common headers from a request.
 * Class DefaultHeaderParser
 * @package LunixREST\RequestFactory\HeaderParser
 */
class DefaultHeaderParser implements HeaderParser
{

    /**
     * @var string
     */
    private $apiKeyHeaderKey;

    /**
     * DefaultHeaderParser constructor.
     * @param string $apiKeyHeaderKey
     */
    public function __construct($apiKeyHeaderKey = 'x-api-key')
    {
        $this->apiKeyHeaderKey = $apiKeyHeaderKey;
    }

    /**
     * @param array $headers
     * @return ParsedHeaders
     */
    public function parse(array $headers): ParsedHeaders
    {
        $contentType = $this->getContentType($headers);
        $acceptableMIMETypes = $this->findAcceptableMIMETypes($headers);
        $apiKey = $this->findAPIKey($headers);

        return new ParsedHeaders($contentType, $acceptableMIMETypes, $apiKey);
    }

    /**
     * @param array $headers
     * @return array
     */
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

    /**
     * @param array $headers
     * @return null
     */
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

    /**
     * @param array $headers
     * @return null
     */
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
