<?php
namespace LunixREST\APIRequest\BodyParser;

use LunixREST\APIRequest\BodyParser\Exceptions\InvalidRequestDataException;
use LunixREST\APIRequest\RequestData\RequestData;

interface BodyParser
{
    /**
     * Parses API request data out of a url
     * @param $rawBody
     * @return RequestData
     * @throws InvalidRequestDataException
     */
    public function parse(string $rawBody): RequestData;
}
