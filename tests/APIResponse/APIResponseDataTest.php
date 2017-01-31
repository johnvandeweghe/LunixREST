<?php
namespace LunixREST\APIResponse;

/**
 * Class APIResponseDataTest
 * @package LunixREST\APIResponse
 */
class APIResponseDataTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersReturnConstructedValues()
    {
        $data = ["some" => new \stdClass()];

        $apiResponseData = new APIResponseData($data);

        $this->assertEquals($data, $apiResponseData->getData());
    }

}
