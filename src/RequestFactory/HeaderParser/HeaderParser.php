<?php
namespace LunixREST\RequestFactory\HeaderParser;

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
     */
    public function parse(array $headers): ParsedHeaders;
}
