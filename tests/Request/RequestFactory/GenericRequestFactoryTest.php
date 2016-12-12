<?php
namespace LunixREST\tests\Request\RequestFactory;

use LunixREST\Request\RequestFactory\GenericRequestFactory;

class GenericRequestFactoryTest extends \PHPUnit_Framework_TestCase {
    public function testA() {
        $version = '1';
        $apiKey = 'public';
        $endpoint = 'geophone';
        $extension = 'json';
        $instance = '123';
        $method = 'get';
        $headers = [];
        $ip = '1.1.1.1';
        $data = '';
        $url = '';


        $mockedRequestData = $this->getMockBuilder('\LunixREST\Request\RequestData\RequestData')->getMock();

        $mockedParsedURL = $this->getMockBuilder('\LunixREST\Request\URLParser\ParsedURL')->disableOriginalConstructor()->getMock();
        $mockedParsedURL->method('getRequestData')->willReturn($mockedRequestData);
        $mockedParsedURL->method('getVersion')->willReturn($version);
        $mockedParsedURL->method('getApiKey')->willReturn($apiKey);
        $mockedParsedURL->method('getEndpoint')->willReturn($endpoint);
        $mockedParsedURL->method('getExtension')->willReturn($extension);
        $mockedParsedURL->method('getInstance')->willReturn($instance);

        $mockedURLParser = $this->getMockBuilder('\LunixREST\Request\URLParser\URLParser')->getMock();
        $mockedURLParser->method('parse')->willReturn($mockedParsedURL);

        $mockedBodyParser = $this->getMockBuilder('\LunixREST\Request\BodyParser\BodyParser')->getMock();
        $mockedBodyParser->method('parse')->willReturn($mockedRequestData);

        $requestFactory = new GenericRequestFactory($mockedURLParser, $mockedBodyParser);

        $request = $requestFactory->create($method, $headers, $data, $ip, $url);

        $this->assertEquals($version, $request->getVersion());
        $this->assertEquals($apiKey, $request->getApiKey());
        $this->assertEquals($endpoint, $request->getEndpoint());
        $this->assertEquals($instance, $request->getInstance());
        $this->assertEquals($extension, $request->getExtension());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($ip, $request->getIp());
        $this->assertEquals($headers, $request->getHeaders());
        $this->assertEquals($mockedRequestData, $request->getBody());
        $this->assertEquals($mockedRequestData, $request->getUrlData());
    }
}
