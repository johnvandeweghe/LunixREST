<?php
namespace LunixREST\Response;

use LunixREST\Response\Exceptions\NotAcceptableResponseTypeException;

interface ResponseFactory {
    /**
     * @param ResponseData $data
     * @param array $acceptedMIMETypes - acceptable MIME types in order of preference
     * @return Response
     * @throws NotAcceptableResponseTypeException
     */
    public function getResponse(ResponseData $data, array $acceptedMIMETypes): Response;
    /**
     * @return string[]
     */
    public function getSupportedMIMETypes(): array;
}
