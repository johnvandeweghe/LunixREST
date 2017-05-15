<?php
namespace LunixREST\RequestFactory;

class DefaultRequestFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testUsesDefaults()
    {
        $mockedURLParser = $this->getMockBuilder('\LunixREST\RequestFactory\URLParser\URLParser')->getMock();

        $requestFactory = new DefaultRequestFactory($mockedURLParser);

        $this->assertEquals($mockedURLParser, $requestFactory->getURLParser());
        $this->assertInstanceOf('\LunixREST\RequestFactory\HeaderParser\DefaultHeaderParser',
            $requestFactory->getHeaderParser());
    }
}
