<?php
namespace LunixREST\APIResponse;

use Psr\Http\Message\StreamInterface;

/**
 * Class APIResponse
 * @package LunixREST\APIResponse
 */
interface APIResponse
{
    /**
     * @return null|object|array
     */
    public function getResponseData();

    public function getMIMEType(): string;

    /**
     * @return StreamInterface
     */
    public function getAsDataStream(): StreamInterface;

}
