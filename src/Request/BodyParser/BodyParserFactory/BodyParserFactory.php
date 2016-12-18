<?php
namespace LunixREST\Request\BodyParser\BodyParserFactory;

use LunixREST\Request\BodyParser\BodyParser;
use LunixREST\Request\BodyParser\BodyParserFactory\Exceptions\UnknownContentTypeException;

interface BodyParserFactory {
    /**
     * Parses API request data out of a url
     * @param string $contentType
     * @return BodyParser
     * @throws UnknownContentTypeException
     */
    public function create(string $contentType): BodyParser;
}
