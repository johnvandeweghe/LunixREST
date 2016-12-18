<?php
namespace LunixREST\tests\Request\RequestFactory;

use LunixREST\Request\RequestFactory\GenericRequestFactory;

class GenericRequestFactoryTest extends \PHPUnit_Framework_TestCase {
    public function testRequestHasProperValues() {
        $version = '1';
        $apiKey = 'public';
        $endpoint = 'geophone';
        $instance = '123';
        $method = 'get';
        $headers = [];
        $ip = '1.1.1.1';
        $data = '';
        $url = '';
        $acceptableMIMETypes = ['application/json'];

        $mockedRequestData = $this->getMockBuilder('\LunixREST\Request\RequestData\RequestData')->getMock();
        $mockedURLParser = $this->mockURLParser($mockedRequestData, $version, $apiKey, $endpoint, $acceptableMIMETypes, $instance);
        $mockedBodyParserFactory = $this->mockBodyParserFactory($mockedRequestData);
        $mockedHeaderParser = $this->mockHeaderParser($acceptableMIMETypes, $apiKey, '');

        $requestFactory = new GenericRequestFactory($mockedURLParser, $mockedBodyParserFactory, $mockedHeaderParser);

        $request = $requestFactory->create($method, $headers, $data, $ip, $url);

        $this->assertEquals($version, $request->getVersion());
        $this->assertEquals($apiKey, $request->getApiKey());
        $this->assertEquals($endpoint, $request->getEndpoint());
        $this->assertEquals($instance, $request->getInstance());
        $this->assertEquals($acceptableMIMETypes, $request->getAcceptableMIMETypes());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($ip, $request->getIp());
        $this->assertEquals($headers, $request->getHeaders());
        $this->assertEquals($mockedRequestData, $request->getBody());
        $this->assertEquals($mockedRequestData, $request->getUrlData());
    }

    public function testHeaderAPIKeyIsUsedWhenURLAPIKeyIsNull() {
        $version = '1';
        $apiKey = 'public';
        $endpoint = 'geophone';
        $instance = '123';
        $method = 'get';
        $headers = [];
        $ip = '1.1.1.1';
        $data = '';
        $url = '';
        $acceptableMIMETypes = ['application/json'];

        $mockedRequestData = $this->getMockBuilder('\LunixREST\Request\RequestData\RequestData')->getMock();
        $mockedURLParser = $this->mockURLParser($mockedRequestData, $version, null, $endpoint, $acceptableMIMETypes, $instance);
        $mockedBodyParserFactory = $this->mockBodyParserFactory($mockedRequestData);
        $mockedHeaderParser = $this->mockHeaderParser($acceptableMIMETypes, $apiKey, '');

        $requestFactory = new GenericRequestFactory($mockedURLParser, $mockedBodyParserFactory, $mockedHeaderParser);

        $request = $requestFactory->create($method, $headers, $data, $ip, $url);

        $this->assertEquals($apiKey, $request->getApiKey());
    }

    public function testGetters() {
        $mockedURLParser = $this->getMockBuilder('\LunixREST\Request\URLParser\URLParser')->getMock();
        $mockedBodyParserFactory = $this->getMockBuilder('\LunixREST\Request\BodyParser\BodyParserFactory\BodyParserFactory')->getMock();
        $mockedHeaderParser = $this->getMockBuilder('\LunixREST\Request\HeaderParser\HeaderParser')->getMock();

        $requestFactory = new GenericRequestFactory($mockedURLParser, $mockedBodyParserFactory, $mockedHeaderParser);

        $this->assertEquals($mockedURLParser, $requestFactory->getURLParser());
        $this->assertEquals($mockedBodyParserFactory, $requestFactory->getBodyParserFactory());
        $this->assertEquals($mockedHeaderParser, $requestFactory->getHeaderParser());
    }

    private function mockURLParser($requestData, $version, $apiKey, $endpoint, $acceptableMIMETypes, $instance) {
        $mockedParsedURL = $this->getMockBuilder('\LunixREST\Request\URLParser\ParsedURL')->disableOriginalConstructor()->getMock();
        $mockedParsedURL->method('getRequestData')->willReturn($requestData);
        $mockedParsedURL->method('getVersion')->willReturn($version);
        $mockedParsedURL->method('getAPIKey')->willReturn($apiKey);
        $mockedParsedURL->method('getEndpoint')->willReturn($endpoint);
        $mockedParsedURL->method('getAcceptableMIMETypes')->willReturn($acceptableMIMETypes);
        $mockedParsedURL->method('getInstance')->willReturn($instance);
        $mockedURLParser = $this->getMockBuilder('\LunixREST\Request\URLParser\URLParser')->getMock();
        $mockedURLParser->method('parse')->willReturn($mockedParsedURL);
        return $mockedURLParser;
    }

    private function mockBodyParserFactory($requestData) {
        $mockedBodyParser = $this->getMockBuilder('\LunixREST\Request\BodyParser\BodyParser')->getMock();
        $mockedBodyParser->method('parse')->willReturn($requestData);
        $mockedBodyParserFactory = $this->getMockBuilder('\LunixREST\Request\BodyParser\BodyParserFactory\BodyParserFactory')->getMock();
        $mockedBodyParserFactory->method('create')->willReturn($mockedBodyParser);
        return $mockedBodyParserFactory;
    }

    private function mockHeaderParser($acceptableMIMETypes, $apiKey, $contentType) {
        $mockedParsedHeaders = $this->getMockBuilder('\LunixREST\Request\HeaderParser\ParsedHeaders')->disableOriginalConstructor()->getMock();
        $mockedParsedHeaders->method('getAcceptableMIMETypes')->willReturn($acceptableMIMETypes);
        $mockedParsedHeaders->method('getAPIKey')->willReturn($apiKey);
        $mockedParsedHeaders->method('getContentType')->willReturn($contentType);
        $mockedHeaderParser = $this->getMockBuilder('\LunixREST\Request\HeaderParser\HeaderParser')->getMock();
        $mockedHeaderParser->method('parse')->willReturn($mockedParsedHeaders);
        return $mockedHeaderParser;
    }

    //TODO: test header api key is used when url api key is null
    //TODO: test both header and url mime types are used
}
