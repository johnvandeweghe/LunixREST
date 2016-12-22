<?php
namespace LunixREST\APIRequest\URLParser;

use LunixREST\APIRequest\URLParser\Exceptions\InvalidRequestURLException;
use Psr\Http\Message\UriInterface;

interface URLParser
{
    /**
     * Parses API request data out of a url
     * @param UriInterface $uri
     * @return ParsedURL
     * @throws InvalidRequestURLException
     */
    public function parse(UriInterface $uri): ParsedURL;
}
