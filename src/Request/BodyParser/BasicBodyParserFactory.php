<?php
namespace LunixREST\Request\BodyParser;

/**
 * A BodyParserFactory that understands url encoded and json encoded content-types.
 * Class BasicBodyParserFactory
 * @package LunixREST\Request\BodyParser
 */
//TODO: Consider renaming to Default*
class BasicBodyParserFactory implements BodyParserFactory {
    /**
     * Parses API request data out of a url
     * @param string $contentType
     * @return BodyParser
     */
    public function create(string $contentType): BodyParser {
        switch($contentType) {
            case 'application/json':
                return new JSONBodyParser();
            case 'application/x-www-form-urlencoded':
            default:
                return new URLEncodedBodyParser();
        }
    }
}
