<?php
namespace LunixREST\Request\BodyParser;

use LunixREST\Request\BodyParser\Exceptions\InvalidRequestDataException;
use LunixREST\Request\RequestData\RequestData;

interface BodyParser {
    /**
     * Parses API request data out of a url
     * @param $rawBody
     * @return RequestData
     * @throws InvalidRequestDataException
     */
    public function parse(string $rawBody): RequestData;
}
