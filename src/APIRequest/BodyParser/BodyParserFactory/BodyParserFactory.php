<?php
namespace LunixREST\APIRequest\BodyParser\BodyParserFactory;

use LunixREST\APIRequest\BodyParser\BodyParser;
use LunixREST\APIRequest\BodyParser\BodyParserFactory\Exceptions\UnknownContentTypeException;

interface BodyParserFactory
{
    /**
     * Parses API request data out of a url
     * @param string $contentType
     * @return BodyParser
     * @throws UnknownContentTypeException
     */
    public function create(string $contentType): BodyParser;
}
