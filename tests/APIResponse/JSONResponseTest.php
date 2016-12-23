<?php
namespace LunixREST\APIResponse;

class JSONResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAsStringReturnsExpectedJSON()
    {
        $data = [
            "Key" => "Value",
            1 => [
                1,
                2,
                3
            ]
        ];

        $expectedData = json_encode($data);

        $JSONResponse = new JSONResponse($data);

        $this->assertEquals($expectedData, $JSONResponse->getAsDataStream()->getContents());
    }

    public function testGetResponseDataReturnsPassedData()
    {
        $data = [
            "Key" => "Value",
            1 => [
                1,
                2,
                3
            ]
        ];

        $JSONResponse = new JSONResponse($data);

        $this->assertEquals($data, $JSONResponse->getResponseData());
    }

    public function testGetMIMETypeReturnsJSONType()
    {
        $JSONResponse = new JSONResponse(null);

        $this->assertEquals('application/json', $JSONResponse->getMIMEType());
    }
}
