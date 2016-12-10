<?php
namespace LunixREST\Response;

use LunixREST\Response\Exceptions\UnknownResponseTypeException;

interface ResponseFactory {
    /**
     * @param ResponseData $data
     * @param string $type
     * @return Response
     * @throws UnknownResponseTypeException
     */
    public function getResponse(ResponseData $data, string $type): Response;
    /**
     * @return string[]
     */
    public function getSupportedTypes(): array;
}
