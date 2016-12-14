<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\BodyParser\BodyParserFactory;
use LunixREST\Request\BodyParser\Exceptions\InvalidRequestDataException;
use LunixREST\Request\BodyParser\Exceptions\UnknownContentTypeException;
use LunixREST\Request\HeaderParser\HeaderParser;
use LunixREST\Request\Request;
use LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\Request\URLParser\URLParser;

class GenericRequestFactory implements RequestFactory {

    /**
     * @var URLParser
     */
    protected $URLParser;
    /**
     * @var BodyParserFactory
     */
    private $bodyParserFactory;
    /**
     * @var HeaderParser
     */
    private $headerParser;

    /**
     * BasicRequestFactory constructor.
     * @param URLParser $URLParser
     * @param BodyParserFactory $bodyParserFactory
     * @param HeaderParser $headerParser
     */
    public function __construct(URLParser $URLParser, BodyParserFactory $bodyParserFactory, HeaderParser $headerParser) {
        $this->URLParser = $URLParser;
        $this->bodyParserFactory = $bodyParserFactory;
        $this->headerParser = $headerParser;
    }

    /**
     * Creates a request from raw $data and a $url
     * @param $method
     * @param array $headers
     * @param string $data
     * @param $ip
     * @param $url
     * @return Request
     * @throws InvalidRequestURLException
     * @throws UnknownContentTypeException
     * @throws InvalidRequestDataException
     */
    public function create($method, array $headers, string $data, $ip, $url): Request {
        $parsedURL = $this->URLParser->parse($url);

        $parsedHeaders = $this->headerParser->parse($headers);

        $bodyParser = $this->bodyParserFactory->create($parsedHeaders->getContentType());
        $parsedData = $bodyParser->parse($data);

        $apiKey = $parsedURL->getAPIKey();
        if(!$apiKey) {
            $apiKey = $parsedHeaders->getAPIKey();
        }

        $acceptableMIMETypes = array_unique(array_merge(
            $parsedURL->getAcceptableMIMETypes(),
            $parsedHeaders->getAcceptableMIMETypes()
        ));

        return new Request($method, $headers, $parsedData, $parsedURL->getRequestData(), $ip, $parsedURL->getVersion(),
            $apiKey, $parsedURL->getEndpoint(), $acceptableMIMETypes, $parsedURL->getInstance());
    }
}
