<?php
namespace LunixREST\tests\Response;

use LunixREST\Response\DefaultResponseFactory;

class DefaultResponseFactoryTest extends \PHPUnit_Framework_TestCase {
    public function testGetResponseOfTypeJSONReturnsJSONResponse(){
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $defaultResponseFactory = new DefaultResponseFactory();

        $this->assertInstanceOf('\LunixREST\Response\JSONResponse', $defaultResponseFactory->getResponse($responseDataMock, 'json'));
    }

    public function testGetResponseOfTypeJSONWithWeirdCaseReturnsJSONResponse(){
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $defaultResponseFactory = new DefaultResponseFactory();

        $this->assertInstanceOf('\LunixREST\Response\JSONResponse', $defaultResponseFactory->getResponse($responseDataMock, 'JsON'));
    }

    public function testGetResponseOfInvalidTypeThrowsException(){
        $responseDataMock = $this->getMockBuilder('\LunixREST\Response\ResponseData')->getMock();

        $defaultResponseFactory = new DefaultResponseFactory();

        $this->expectException('\LunixREST\Response\Exceptions\UnknownResponseTypeException');
        $defaultResponseFactory->getResponse($responseDataMock, 'notJSON');
    }

    public function testGetSupportedTypesReturnsJSON(){
        $expected = ["json"];
        $defaultResponseFactory = new DefaultResponseFactory();

        $this->assertEquals($expected, $defaultResponseFactory->getSupportedTypes());
    }
}
