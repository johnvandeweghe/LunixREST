<?php
namespace LunixREST\RequestFactory;

use LunixREST\RequestFactory\Exceptions\UnableToCreateRequestException;
use LunixREST\RequestFactory\HeaderParser\Exceptions\UnableToParseHeadersException;
use LunixREST\RequestFactory\HeaderParser\HeaderParser;
use LunixREST\RequestFactory\URLParser\Exceptions\UnableToParseURLException;
use LunixREST\RequestFactory\URLParser\URLParser;
use LunixREST\Server\APIRequest\APIRequest;
use Psr\Http\Message\ServerRequestInterface;

/**
 * A generic Request Factory that derives it's behavior from a URLParser and a HeaderParser. Uses the requests Parsed Body.
 * Class GenericRequestFactory
 * @package LunixREST\RequestFactory
 */
class GenericRequestFactory implements RequestFactory {

    /**
     * @var URLParser
     */
    protected $URLParser;
    /**
     * @var HeaderParser
     */
    private $headerParser;

    /**
     * BasicRequestFactory constructor.
     * @param URLParser $URLParser
     * @param HeaderParser $headerParser
     */
    public function __construct(URLParser $URLParser, HeaderParser $headerParser)
    {
        $this->URLParser = $URLParser;
        $this->headerParser = $headerParser;
    }

    /**
     * Creates a request from raw $data and a $url
     * @param ServerRequestInterface $serverRequest
     * @return APIRequest
     * @throws UnableToCreateRequestException
     * @throws UnableToParseHeadersException
     * @throws UnableToParseURLException
     */
    public function create(ServerRequestInterface $serverRequest): APIRequest
    {
        $parsedURL = $this->URLParser->parse($serverRequest->getUri());

        //TODO: Evaluate if this is still needed, as serverRequest allows getting of specific headers
        $parsedHeaders = $this->headerParser->parse($serverRequest->getHeaders());

        $urlQueryData = [];
        if($urlQueryString = $parsedURL->getQueryString()) {
            parse_str($urlQueryString, $urlQueryData);
        }

        $apiKey = $parsedURL->getAPIKey();
        if($apiKey === null) {
            $apiKey = $parsedHeaders->getAPIKey();
        }

        $acceptableMIMETypes = array_unique(array_merge(
            $parsedURL->getAcceptableMIMETypes(),
            $parsedHeaders->getAcceptableMIMETypes()
        ));

        return new APIRequest($serverRequest->getMethod(), $parsedURL->getEndpoint(), $parsedURL->getElement(),
            $acceptableMIMETypes, $parsedURL->getVersion(), $apiKey, $urlQueryData, $serverRequest->getParsedBody());
    }

    /**
     * @return URLParser
     */
    public function getURLParser(): URLParser
    {
        return $this->URLParser;
    }

    /**
     * @return HeaderParser
     */
    public function getHeaderParser(): HeaderParser
    {
        return $this->headerParser;
    }
}
