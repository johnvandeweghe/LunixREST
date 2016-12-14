<?php
namespace LunixREST\tests\Request\RequestFactory;

use LunixREST\Request\RequestFactory\GenericRequestFactory;

//TODO: This needs more test cases
class GenericRequestFactoryTest extends \PHPUnit_Framework_TestCase {

    public function testA() {
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

        $mockedParsedURL = $this->getMockBuilder('\LunixREST\Request\URLParser\ParsedURL')->disableOriginalConstructor()->getMock();
        $mockedParsedURL->method('getRequestData')->willReturn($mockedRequestData);
        $mockedParsedURL->method('getVersion')->willReturn($version);
        $mockedParsedURL->method('getAPIKey')->willReturn($apiKey);
        $mockedParsedURL->method('getEndpoint')->willReturn($endpoint);
        $mockedParsedURL->method('getAcceptableMIMETypes')->willReturn($acceptableMIMETypes);
        $mockedParsedURL->method('getInstance')->willReturn($instance);
        $mockedURLParser = $this->getMockBuilder('\LunixREST\Request\URLParser\URLParser')->getMock();
        $mockedURLParser->method('parse')->willReturn($mockedParsedURL);

        $mockedBodyParser = $this->getMockBuilder('\LunixREST\Request\BodyParser\BodyParser')->getMock();
        $mockedBodyParser->method('parse')->willReturn($mockedRequestData);
        $mockedBodyParserFactory = $this->getMockBuilder('\LunixREST\Request\BodyParser\BodyParserFactory')->getMock();
        $mockedBodyParserFactory->method('create')->willReturn($mockedBodyParser);

        $mockedParsedHeaders = $this->getMockBuilder('\LunixREST\Request\HeaderParser\ParsedHeaders')->disableOriginalConstructor()->getMock();
        $mockedParsedHeaders->method('getAcceptableMIMETypes')->willReturn($acceptableMIMETypes);
        $mockedParsedHeaders->method('getAPIKey')->willReturn($apiKey);
        $mockedParsedHeaders->method('getContentType')->willReturn('');
        $mockedHeaderParser = $this->getMockBuilder('\LunixREST\Request\HeaderParser\HeaderParser')->getMock();
        $mockedHeaderParser->method('parse')->willReturn($mockedParsedHeaders);

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

    //TODO: test header api key is used when url api key is null
    //TODO: test both header and url mime types are used
}
