<?php
namespace LunixREST\Request\BodyParser;

use LunixREST\Request\BodyParser\Exceptions\InvalidRequestDataException;
use LunixREST\Request\RequestData\RequestData;
use LunixREST\Request\RequestData\URLEncodedQueryStringRequestData;

class URLEncodedBodyParser implements BodyParser
{

    /**
     * Parses API request data out of a url
     * @param $rawBody
     * @return RequestData
     * @throws InvalidRequestDataException
     */
    public function parse(string $rawBody): RequestData
    {
        return new URLEncodedQueryStringRequestData($rawBody);
    }
}
