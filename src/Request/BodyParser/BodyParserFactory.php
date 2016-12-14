<?php
namespace LunixREST\Request\BodyParser;

use LunixREST\Request\BodyParser\Exceptions\UnknownContentTypeException;

interface BodyParserFactory {
    /**
     * Parses API request data out of a url
     * @param string $contentType
     * @return BodyParser
     * @throws UnknownContentTypeException
     */
    public function create(string $contentType): BodyParser;
}
