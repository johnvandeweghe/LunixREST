<?php
namespace LunixREST\Request\BodyParser;

use LunixREST\Request\BodyParser\Exceptions\InvalidRequestDataException;
use LunixREST\Request\RequestData\JSONRequestData;
use LunixREST\Request\RequestData\RequestData;

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
