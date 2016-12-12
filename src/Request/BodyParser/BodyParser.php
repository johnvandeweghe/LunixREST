<?php
namespace LunixREST\Request\BodyParser;

use LunixREST\Request\RequestData\RequestData;

interface BodyParser {
    /**
     * Parses API request data out of a url
     * @param $rawBody
     * @return RequestData
     */
    public function parse(string $rawBody): RequestData;
}
