<?php
namespace LunixREST\Request\URLParser;

use LunixREST\Request\MIMEProvider;
use LunixREST\Request\RequestData\URLEncodedQueryStringRequestData;
use LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException;

/**
 * A basic URL parser. Expects URLS in the format:
 * /VERSION/APIKEY/ENDPOINT_NAME[/INSTANCE_ID].EXTENSION[?QUERY_STRING]
 * Class BasicURLParser
 * @package LunixREST\Request\URLParser
 */
class BasicURLParser implements URLParser
{

    /**
     * @var MIMEProvider
     */
    private $MIMEProvider;

    /**
     * BasicURLParser constructor.
     * @param MIMEProvider $MIMEProvider
     */
    public function __construct(MIMEProvider $MIMEProvider)
    {
        $this->MIMEProvider = $MIMEProvider;
    }

    /**
     * Parses API request data out of a url
     * @param string $url
     * @return ParsedURL
     * @throws InvalidRequestURLException
     */
    public function parse(string $url): ParsedURL
    {
        $splitURL = explode('/', trim($url, '/'));
        if (count($splitURL) < 3) {
            throw new InvalidRequestURLException();
        }
        //Find endpoint
        $version = $splitURL[0];
        $apiKey = $splitURL[1];
        $endpoint = $splitURL[2];

        $splitExtension = explode('.', $splitURL[count($splitURL) - 1]);
        $extension = array_pop($splitExtension);

        $instance = null;

        if (count($splitURL) == 4) {
            $instance = implode('.', $splitExtension);
        } else {
            $endpoint = implode('.', $splitExtension);
        }

        $splitOnQuery = explode('?', $url);
        $queryString = $splitOnQuery[1] ?? '';

        $requestData = new URLEncodedQueryStringRequestData($queryString);

        $mime = $this->MIMEProvider->getByFileExtension($extension);

        return new ParsedURL($requestData, $version, $apiKey, $endpoint, $mime ? [$mime] : [], $instance);
    }
}
