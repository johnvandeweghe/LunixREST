<?php
namespace LunixREST\APIResponse;

use Psr\Http\Message\StreamInterface;

/**
 * Class APIResponse
 * @package LunixREST\APIResponse
 */
class APIResponse
{
    /**
     * @var string
     */
    protected $MIMEType;
    /**
     * @var StreamInterface
     */
    protected $stream;

    public function __construct(string $MIMEType, StreamInterface $stream)
    {
        $this->MIMEType = $MIMEType;
        $this->stream = $stream;
    }

    public function getMIMEType(): string {
        return $this->MIMEType;
    }

    /**
     * @return StreamInterface
     */
    public function getAsDataStream(): StreamInterface {
        return $this->stream;
    }

}
