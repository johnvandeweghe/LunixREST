<?php
namespace LunixREST\RequestFactory\HeaderParser;

use LunixREST\RequestFactory\HeaderParser\Exceptions\UnableToParseHeadersException;

/**
 * Used to build a ParsedHeaders object from a request's headers. Decides how to pull API keys and such.
 * Interface HeaderParser
 * @package LunixREST\RequestFactory\HeaderParser
 */
interface HeaderParser
{
    /**
     * @param array $headers
     * @return ParsedHeaders
     * @throws UnableToParseHeadersException
     */
    public function parse(array $headers): ParsedHeaders;
}
