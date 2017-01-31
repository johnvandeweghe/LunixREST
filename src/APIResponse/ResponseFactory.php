<?php
namespace LunixREST\APIResponse;

use LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException;

interface ResponseFactory
{
    /**
     * @param APIResponseData $data
     * @param array $acceptedMIMETypes - acceptable MIME types in order of preference
     * @return APIResponse
     * @throws NotAcceptableResponseTypeException
     */
    public function getResponse(APIResponseData $data, array $acceptedMIMETypes): APIResponse;

    /**
     * @return string[]
     */
    public function getSupportedMIMETypes(): array;
}
