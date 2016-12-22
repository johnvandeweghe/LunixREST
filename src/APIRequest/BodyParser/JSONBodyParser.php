<?php
namespace LunixREST\APIRequest\BodyParser;

use LunixREST\APIRequest\BodyParser\Exceptions\InvalidRequestDataException;
use LunixREST\APIRequest\RequestData\JSONRequestData;
use LunixREST\APIRequest\RequestData\RequestData;

class JSONBodyParser implements BodyParser
{

    /**
     * Parses API request data out of a json string
     * @param $rawBody
     * @return RequestData
     * @throws InvalidRequestDataException
     */
    public function parse(string $rawBody): RequestData
    {
        return new JSONRequestData($rawBody);
    }
}
