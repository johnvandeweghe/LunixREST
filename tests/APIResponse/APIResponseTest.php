<?php
namespace LunixREST\APIResponse;

/**
 * Class APIResponseTest
 * @package LunixREST\APIResponse
 */
class APIResponseTest extends \PHPUnit\Framework\TestCase
{
    public function testGettersReturnConstructedValues()
    {
        $mimeType = 'application/test';
        $mockedStream = $this->getMockBuilder('\Psr\Http\Message\StreamInterface')->getMock();

        $apiResponse = new APIResponse($mimeType, $mockedStream);

        $this->assertEquals($mimeType, $apiResponse->getMIMEType());
        $this->assertEquals($mockedStream, $apiResponse->getAsDataStream());
    }

}
