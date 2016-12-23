<?php
namespace LunixREST\APIRequest\RequestFactory;

class DefaultRequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testUsesDefaults()
    {
        $mockedURLParser = $this->getMockBuilder('\LunixREST\APIRequest\URLParser\URLParser')->getMock();

        $requestFactory = new DefaultRequestFactory($mockedURLParser);

        $this->assertEquals($mockedURLParser, $requestFactory->getURLParser());
        $this->assertInstanceOf('\LunixREST\APIRequest\HeaderParser\DefaultHeaderParser',
            $requestFactory->getHeaderParser());
    }
}
