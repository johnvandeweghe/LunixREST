<?php
namespace LunixREST\Request\BodyParser;

class BasicBodyParserFactory implements BodyParserFactory {
    /**
     * Parses API request data out of a url
     * @param string $contentType
     * @return BodyParser
     */
    public function create(string $contentType): BodyParser {
        switch($contentType) {
            case 'application/x-www-form-urlencoded':
            default:
                return new URLEncodedBodyParser();
            case 'application/json':
                return new JSONBodyParser();
        }
    }
}
