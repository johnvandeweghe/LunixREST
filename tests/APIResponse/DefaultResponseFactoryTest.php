<?php
namespace LunixREST\APIResponse;

class DefaultResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetResponseOfTypeJSONReturnsJSONResponse()
    {
        $responseData = ["foo" => "bar"];

        $defaultResponseFactory = new DefaultResponseFactory();

        $response = $defaultResponseFactory->getResponse($responseData, ['application/json']);

        $this->assertInstanceOf('\LunixREST\APIResponse\JSONResponse', $response);
    }

    public function testGetResponseOfTypesNotAnJSONReturnsJSONResponse()
    {
        $responseData = ["foo" => "bar"];

        $defaultResponseFactory = new DefaultResponseFactory();

        $response = $defaultResponseFactory->getResponse($responseData, ['notJSON', 'application/json']);

        $this->assertInstanceOf('\LunixREST\APIResponse\JSONResponse', $response);
    }

    public function testGetResponseOfTypeJSONWithWeirdCaseReturnsJSONResponse()
    {
        $responseData = ["foo" => "bar"];

        $defaultResponseFactory = new DefaultResponseFactory();

        $response = $defaultResponseFactory->getResponse($responseData, ['application/jSoN']);

        $this->assertInstanceOf('\LunixREST\APIResponse\JSONResponse', $response);
    }

    public function testGetResponseOfInvalidTypeThrowsException()
    {
        $responseData = ["foo" => "bar"];

        $defaultResponseFactory = new DefaultResponseFactory();

        $this->expectException('\LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException');
        $defaultResponseFactory->getResponse($responseData, ['notJSON']);
    }

    public function testGetSupportedMIMETypesReturnsJSON()
    {
        $expected = ["application/json"];
        $defaultResponseFactory = new DefaultResponseFactory();

        $this->assertEquals($expected, $defaultResponseFactory->getSupportedMIMETypes());
    }
}
