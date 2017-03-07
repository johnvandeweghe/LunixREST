<?php
namespace LunixREST\APIRequest\HeaderParser;

/**
 * Used to build a ParsedHeaders object from a request's headers. Decides how to pull API keys and such.
 * Interface HeaderParser
 * @package LunixREST\APIRequest\HeaderParser
 */
interface HeaderParser
{
    /**
     * @param array $headers
     * @return ParsedHeaders
     */
    public function parse(array $headers): ParsedHeaders;
}
