<?php
namespace LunixREST\Request\HeaderParser;

class BasicHeaderParser implements HeaderParser {

    private $apiKeyHeaderKey;

    /**
     * BasicHeaderParser constructor.
     * @param string $apiKeyHeaderKey
     */
    public function __construct($apiKeyHeaderKey = 'x-api-key') {
        $this->apiKeyHeaderKey = $apiKeyHeaderKey;
    }

    public function findAcceptableMIMETypes(array $headers): array{
        //TODO: follow RFC2616 order
        $acceptedMIMETypes = [];
        foreach($headers as $key => $value) {
            if(strtolower($key) == 'http-accept'){
                $values = explode(',', $value);
                foreach($values as $acceptedType) {
                    $typeParts = explode(';', $acceptedType);
                    if(count($typeParts) > 0 ){
                        $acceptedMIMETypes[] = trim($typeParts);
                    }
                }
                break;
            }
        }
        return $acceptedMIMETypes;
    }

    public function findAPIKey(array $headers){
        foreach($headers as $key => $value) {
            if(strtolower($key) == $this->apiKeyHeaderKey){
                return $value;
            }
        }
        return null;
    }

    public function getContentType(array $headers){
        foreach($headers as $key => $value) {
            if(strtolower($key) == 'content-type'){
                return $value;
            }
        }
        return null;
    }

    public function parse(array $headers): ParsedHeaders {
        $contentType = $this->getContentType($headers);
        $acceptableMIMETypes = $this->findAcceptableMIMETypes($headers);
        $apiKey = $this->findAPIKey($headers);

        return new ParsedHeaders($contentType, $acceptableMIMETypes, $apiKey);
    }
}
