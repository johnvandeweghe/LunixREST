<?php
namespace LunixREST\APIResponse;

use Psr\Http\Message\StreamInterface;

/**
 * An Interface for converting APIResponseData into a PSR-7 StreamInterface, so that it can be transmitted.
 * Interface APIResponseDataSerializer
 * @package LunixREST\APIResponse
 */
interface APIResponseDataSerializer {
    /**
     * @param APIResponseData $responseData
     * @return StreamInterface
     */
    public function serialize(APIResponseData $responseData): StreamInterface;
}
