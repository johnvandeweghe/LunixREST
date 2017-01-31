<?php
namespace LunixREST\APIResponse;

use Psr\Http\Message\StreamInterface;

/**
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
