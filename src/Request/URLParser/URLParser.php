<?php
namespace LunixREST\Request\URLParser;

use LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException;

interface URLParser {
    /**
     * Parses API request data out of a url
     * @param $url
     * @return ParsedURL
     * @throws InvalidRequestURLException
     */
    public function parse(string $url): ParsedURL;
}
