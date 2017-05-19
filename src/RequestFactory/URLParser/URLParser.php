<?php
namespace LunixREST\RequestFactory\URLParser;

use LunixREST\RequestFactory\URLParser\Exceptions\InvalidRequestURLException;
use Psr\Http\Message\UriInterface;

/**
 * An interface for converting a PSR-7 UriInterface into a Parsed URL (used in building an APIRequest).
 * Interface URLParser
 * @package LunixREST\RequestFactory\URLParser
 */
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