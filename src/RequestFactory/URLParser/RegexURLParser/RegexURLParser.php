<?php
namespace LunixREST\RequestFactory\URLParser\RegexURLParser;

use LunixREST\RequestFactory\URLParser\Exceptions\UnableToParseURLException;
use LunixREST\RequestFactory\URLParser\Exceptions\UnableToProvideMIMEException;
use LunixREST\RequestFactory\URLParser\MIMEProvider;
use LunixREST\RequestFactory\URLParser\ParsedURL;
use LunixREST\RequestFactory\URLParser\RegexURLParser\Exceptions\InvalidRegexPatternException;
use LunixREST\RequestFactory\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\RequestFactory\URLParser\URLParser;
use Psr\Http\Message\UriInterface;


/**
 * An implementation of a URLParser that uses named regex capture groups to parse urls.
 * Class RegexURLParser
 * @package LunixREST\RequestFactory\URLParser\RegexURLParser
 */
class RegexURLParser implements URLParser
{
    /**
     * @var string
     */
    protected $pattern;
    /**
     * @var MIMEProvider|null
     */
    private $MIMEProvider;

    /**
     * RegexURLParser constructor.
     * @param string $pattern - a pattern that matches named groups: endpoint. And optionally: element, version, apiKey, acceptableExtension
     * @param MIMEProvider|null $MIMEProvider
     * @throws InvalidRegexPatternException
     */
    public function __construct(string $pattern, ?MIMEProvider $MIMEProvider = null)
    {
        $this->pattern = $pattern;

        if(@preg_match($pattern, null) === false) {
            throw new InvalidRegexPatternException("Unable to parse regex pattern", preg_last_error());
        }
        $this->MIMEProvider = $MIMEProvider;
    }

    /**
     * Parses API request data out of a url
     * @param UriInterface $uri
     * @return ParsedURL
     * @throws UnableToParseURLException
     * @throws InvalidRequestURLException
     */
    public function parse(UriInterface $uri): ParsedURL
    {
        $matches = [];
        if(preg_match($this->pattern, $uri->getPath(), $matches) === 0) {
            throw new InvalidRequestURLException("Unable to parse request path: did not match regex");
        }
        if(!($endpoint = $matches["endpoint"] ?? null)) {
            throw new InvalidRequestURLException("Unable to match endpoint in url");
        }
        $element = $matches["element"] ?? null;
        $version = $matches["version"] ?? null;
        $apiKey = $matches["apiKey"] ?? null;

        $acceptableMimeTypes = [];
        if(($acceptableExtension = $matches["acceptableExtension"] ?? null)) {
            if(!$this->MIMEProvider) {
                throw new UnableToParseURLException("Unable to accept acceptable extensions");
            } else {
                try {
                    $acceptableMimeTypes[] = $this->MIMEProvider->provideMIME($acceptableExtension);
                } catch (UnableToProvideMIMEException $exception) {
                    throw new UnableToParseURLException($exception->getMessage());
                }
            }
        }

        return new ParsedURL($endpoint, $element, $version, $apiKey, $acceptableMimeTypes, $uri->getQuery());
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

}
