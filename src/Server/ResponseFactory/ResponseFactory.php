<?php
namespace LunixREST\Server\ResponseFactory;

use LunixREST\Server\APIResponse\APIResponse;
use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\ResponseFactory\Exceptions\UnableToCreateAPIResponseException;

/**
 * An interface for converting ResponseData into an APIResponse.
 * Interface ResponseFactory
 * @package LunixREST\Server\ResponseFactory
 */
interface ResponseFactory
{
    /**
     * @param APIResponseData $data
     * @param array $acceptedMIMETypes - acceptable MIME types in order of preference
     * @return APIResponse
     * @throws UnableToCreateAPIResponseException
     */
    public function getResponse(APIResponseData $data, array $acceptedMIMETypes): APIResponse;

    /**
     * @return string[]
     */
    public function getSupportedMIMETypes(): array;
}
