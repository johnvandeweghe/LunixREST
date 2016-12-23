<?php
namespace LunixREST\APIResponse;

use Psr\Http\Message\StreamInterface;

/**
 * Class JSONResponse
 * @package LunixREST\APIResponse
 */
class JSONResponse implements APIResponse
{
    /**
     * @var null|object|array
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return StreamInterface
     */
    public function getAsDataStream(): StreamInterface
    {
        return \GuzzleHttp\Psr7\Stream_for(json_encode($this->data));
    }

    public function getMIMEType(): string
    {
        return 'application/json';
    }

    /**
     * @return null|object|array
     */
    public function getResponseData()
    {
        return $this->data;
    }
}
