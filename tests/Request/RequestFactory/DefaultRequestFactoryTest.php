<?php
namespace LunixREST\Request\RequestFactory;

class DefaultRequestFactoryTest extends \PHPUnit_Framework_TestCase {
    public function testUsesDefaults() {
        $mockedURLParser = $this->getMockBuilder('\LunixREST\Request\URLParser\URLParser')->getMock();

        $requestFactory = new DefaultRequestFactory($mockedURLParser);

        $this->assertEquals($mockedURLParser, $requestFactory->getURLParser());
        $this->assertInstanceOf('\LunixREST\Request\BodyParser\BodyParserFactory\DefaultBodyParserFactory', $requestFactory->getBodyParserFactory());
        $this->assertInstanceOf('\LunixREST\Request\HeaderParser\DefaultHeaderParser', $requestFactory->getHeaderParser());
    }
}
