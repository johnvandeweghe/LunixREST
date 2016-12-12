<?php
namespace LunixREST\Request\BodyParser;

use LunixREST\Request\RequestData\RequestData;
use LunixREST\Request\RequestData\URLEncodedQueryStringRequestData;

class URLEncodedBodyParser implements BodyParser {

    /**
     * Parses API request data out of a url
     * @param $rawBody
     * @return RequestData
     */
    public function parse(string $rawBody): RequestData {
        return new URLEncodedQueryStringRequestData($rawBody);
    }
}
