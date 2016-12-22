<?php
namespace LunixREST\APIResponse;

use LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException;

interface ResponseFactory
{
    /**
     * @param null|object|array $data
     * @param array $acceptedMIMETypes - acceptable MIME types in order of preference
     * @return APIResponse
     * @throws NotAcceptableResponseTypeException
     */
    public function getResponse($data, array $acceptedMIMETypes): APIResponse;

    /**
     * @return string[]
     */
    public function getSupportedMIMETypes(): array;
}
