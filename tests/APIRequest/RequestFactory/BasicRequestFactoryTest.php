<?php
namespace LunixREST\APIRequest\RequestFactory;

class BasicRequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testUsesDefaultsAndBasic()
    {
        $requestFactory = new BasicRequestFactory();

        $this->assertInstanceOf('\LunixREST\APIRequest\URLParser\BasicURLParser', $requestFactory->getURLParser());
        $this->assertInstanceOf('\LunixREST\APIRequest\HeaderParser\DefaultHeaderParser',
            $requestFactory->getHeaderParser());
    }
}
