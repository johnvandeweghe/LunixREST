<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\BodyParser\BodyParser;
use LunixREST\Request\MIMEProvider;
use LunixREST\Request\Request;
use LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\Request\URLParser\URLParser;

class GenericRequestFactory implements RequestFactory {

    /**
     * @var URLParser
     */
    protected $URLParser;
    /**
     * @var BodyParser
     */
    private $bodyParser;
    /**
     * @var MIMEProvider
     */
    private $MIMEProvider;

    /**
     * BasicRequestFactory constructor.
     * @param URLParser $URLParser
     * @param BodyParser $bodyParser
     * @param MIMEProvider $MIMEProvider
     */
    public function __construct(URLParser $URLParser, BodyParser $bodyParser, MIMEProvider $MIMEProvider) {
        $this->URLParser = $URLParser;
        $this->bodyParser = $bodyParser;
        $this->MIMEProvider = $MIMEProvider;
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
     */
    public function create($method, array $headers, string $data, $ip, $url): Request {
        $parsedURL = $this->URLParser->parse($url);
        $parsedData = $this->bodyParser->parse($data);

        //TODO: check headers for X-API-KEY and possibly use it instead of the parsedURL api key

        return new Request($this->MIMEProvider, $method, $headers, $parsedData, $parsedURL->getRequestData(), $ip, $parsedURL->getVersion(),
            $parsedURL->getApiKey(), $parsedURL->getEndpoint(), $parsedURL->getExtension(), $parsedURL->getInstance());
    }
}