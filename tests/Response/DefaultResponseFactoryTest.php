<?php
namespace LunixREST\Response;

class DefaultResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetResponseOfTypeJSONReturnsJSONResponse()
    {
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $defaultResponseFactory = new DefaultResponseFactory();

        $response = $defaultResponseFactory->getResponse($responseDataMock, ['application/json']);

        $this->assertInstanceOf('\LunixREST\Response\JSONResponse', $response);
    }

    public function testGetResponseOfTypesNotAnJSONReturnsJSONResponse()
    {
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $defaultResponseFactory = new DefaultResponseFactory();

        $response = $defaultResponseFactory->getResponse($responseDataMock, ['notJSON', 'application/json']);

        $this->assertInstanceOf('\LunixREST\Response\JSONResponse', $response);
    }

    public function testGetResponseOfTypeJSONWithWeirdCaseReturnsJSONResponse()
    {
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $defaultResponseFactory = new DefaultResponseFactory();

        $response = $defaultResponseFactory->getResponse($responseDataMock, ['application/jSoN']);

        $this->assertInstanceOf('\LunixREST\Response\JSONResponse', $response);
    }

    public function testGetResponseOfInvalidTypeThrowsException()
    {
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $defaultResponseFactory = new DefaultResponseFactory();

        $this->expectException('\LunixREST\Response\Exceptions\NotAcceptableResponseTypeException');
        $defaultResponseFactory->getResponse($responseDataMock, ['notJSON']);
    }

    public function testGetSupportedMIMETypesReturnsJSON()
    {
        $expected = ["application/json"];
        $defaultResponseFactory = new DefaultResponseFactory();

        $this->assertEquals($expected, $defaultResponseFactory->getSupportedMIMETypes());
    }
}
