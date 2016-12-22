<?php
namespace LunixREST\APIRequest\RequestFactory;

use LunixREST\APIRequest\HeaderParser\HeaderParser;
use LunixREST\APIRequest\APIRequest;
use LunixREST\APIRequest\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\APIRequest\URLParser\URLParser;
use Psr\Http\Message\ServerRequestInterface;

/**
 * A generic Request Factory that derives it's behavior from a URLParser, a BodyParserFactory, and a HeaderParser.
 * Class GenericRequestFactory
 * @package LunixREST\Request\RequestFactory
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
     * @throws InvalidRequestURLException
     */
    public function create(ServerRequestInterface $serverRequest): APIRequest
    {
        $parsedURL = $this->URLParser->parse($serverRequest->getUri());

        $parsedHeaders = $this->headerParser->parse($serverRequest->getHeaders());

        $urlQueryData = [];
        if($urlQueryString = $parsedURL->getQueryString())
        {
            parse_str($parsedURL->getQueryString(), $urlQueryData);
        }

        $apiKey = $parsedURL->getAPIKey();
        if($apiKey === null)
        {
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
