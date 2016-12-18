<?php
namespace LunixREST\tests\Request\RequestFactory;

use LunixREST\Request\RequestFactory\BasicRequestFactory;

class BasicRequestFactoryTest extends \PHPUnit_Framework_TestCase {
    public function testUsesDefaultsAndBasic() {
        $requestFactory = new BasicRequestFactory();

        $this->assertInstanceOf('\LunixREST\Request\URLParser\BasicURLParser', $requestFactory->getURLParser());
        $this->assertInstanceOf('\LunixREST\Request\BodyParser\BodyParserFactory\DefaultBodyParserFactory', $requestFactory->getBodyParserFactory());
        $this->assertInstanceOf('\LunixREST\Request\HeaderParser\DefaultHeaderParser', $requestFactory->getHeaderParser());
    }
}