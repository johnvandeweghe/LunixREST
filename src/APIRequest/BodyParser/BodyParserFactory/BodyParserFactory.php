<?php
namespace LunixREST\APIRequest\BodyParser\BodyParserFactory;

use LunixREST\APIRequest\BodyParser\BodyParser;
use LunixREST\APIRequest\BodyParser\BodyParserFactory\Exceptions\UnknownContentTypeException;

/**
 * UNUSED. Will be migrated to a higher level HTTP parsing area. This namespace is for APIRequest handling, which should
 * already have the http body parsed.
 * Interface BodyParserFactory
 * @package LunixREST\APIRequest\BodyParser\BodyParserFactory
 */
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
