<?php
namespace LunixREST\Server\APIResponse;

/**
 * Class APIResponseDataTest
 * @package LunixREST\APIResponse
 */
class APIResponseDataTest extends \PHPUnit\Framework\TestCase
{
    public function testGettersReturnConstructedValues()
    {
        $data = ["some" => new \stdClass()];

        $apiResponseData = new APIResponseData($data);

        $this->assertEquals($data, $apiResponseData->getData());
    }

}
