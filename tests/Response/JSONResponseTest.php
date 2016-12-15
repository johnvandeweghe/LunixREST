<?php
namespace LunixREST\tests\Response;

use LunixREST\Response\JSONResponse;

class JSONResponseTest extends \PHPUnit_Framework_TestCase {
    public function testGetAsStringReturnsExpectedJSON(){
        $data = [
            "Key" => "Value",
            1 => [
                1,
                2,
                3
            ]
        ];

        $expectedData = json_encode($data);

        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();
        $responseDataMock->method('getAsAssociativeArray')->willReturn($data);

        $JSONResponse = new JSONResponse($responseDataMock);

        $this->assertEquals($expectedData, $JSONResponse->getAsString());
    }

    public function testGetResponseDataReturnsPassedData(){
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $JSONResponse = new JSONResponse($responseDataMock);

        $this->assertEquals($responseDataMock, $JSONResponse->getResponseData());
    }

    public function testgetMIMETypeReturnsJSONType(){
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $JSONResponse = new JSONResponse($responseDataMock);

        $this->assertEquals('application/json', $JSONResponse->getMIMEType());
    }
}
