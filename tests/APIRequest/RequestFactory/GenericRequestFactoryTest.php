<?php
namespace LunixREST\APIRequest\RequestFactory;

class GenericRequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testRequestHasProperValues()
    {
        $endpoint = 'geophone';
        $element = '123';
        $version = '1';
        $apiKey = 'public';
        $queryString = "foo=bar";
        $queryData = ["foo"=>"bar"];
        $method = 'get';
        $headers = [];
        $data = [];
        $acceptableMIMETypes = ['application/json'];

        $mockedURLParser = $this->mockURLParser($endpoint, $element, $version, $apiKey, $acceptableMIMETypes, $queryString);
        $mockedHeaderParser = $this->mockHeaderParser($acceptableMIMETypes, $apiKey, '');

        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();
        $mockedServerRequest->method('getURI')->willReturn($mockedURI);
        $mockedServerRequest->method('getHeaders')->willReturn($headers);
        $mockedServerRequest->method('getMethod')->willReturn($method);
        $mockedServerRequest->method('getParsedBody')->willReturn($data);


        $requestFactory = new GenericRequestFactory($mockedURLParser, $mockedHeaderParser);

        $request = $requestFactory->create($mockedServerRequest);

        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($endpoint, $request->getEndpoint());
        $this->assertEquals($element, $request->getElement());
        $this->assertEquals($acceptableMIMETypes, $request->getAcceptableMIMETypes());
        $this->assertEquals($version, $request->getVersion());
        $this->assertEquals($apiKey, $request->getApiKey());
        $this->assertEquals($queryData, $request->getQueryData());
        $this->assertEquals($data, $request->getData());
    }

    public function testHeaderAPIKeyIsUsedWhenURLAPIKeyIsNull()
    {
        $endpoint = 'geophone';
        $element = '123';
        $version = '1';
        $apiKey = 'public';
        $queryString = "foo=bar";
        $method = 'get';
        $headers = [];
        $data = [];
        $acceptableMIMETypes = ['application/json'];

        $mockedURLParser = $this->mockURLParser($endpoint, $element, $version, null, $acceptableMIMETypes, $queryString);
        $mockedHeaderParser = $this->mockHeaderParser($acceptableMIMETypes, $apiKey, '');

        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();

        $mockedServerRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();
        $mockedServerRequest->method('getURI')->willReturn($mockedURI);
        $mockedServerRequest->method('getHeaders')->willReturn($headers);
        $mockedServerRequest->method('getMethod')->willReturn($method);
        $mockedServerRequest->method('getParsedBody')->willReturn($data);

        $requestFactory = new GenericRequestFactory($mockedURLParser, $mockedHeaderParser);

        $request = $requestFactory->create($mockedServerRequest);

        $this->assertEquals($apiKey, $request->getApiKey());
    }

    public function testGetters()
    {
        $mockedURLParser = $this->getMockBuilder('\LunixREST\APIRequest\URLParser\URLParser')->getMock();
        $mockedHeaderParser = $this->getMockBuilder('\LunixREST\APIRequest\HeaderParser\HeaderParser')->getMock();

        $requestFactory = new GenericRequestFactory($mockedURLParser, $mockedHeaderParser);

        $this->assertEquals($mockedURLParser, $requestFactory->getURLParser());
        $this->assertEquals($mockedHeaderParser, $requestFactory->getHeaderParser());
    }

    private function mockURLParser($endpoint, $element, $version, $apiKey, $acceptableMIMETypes, $queryString)
    {
        //$endpoint, $element, $version, $APIKey, $acceptableMIMETypes, $queryString
        $mockedParsedURL = $this->getMockBuilder('\LunixREST\APIRequest\URLParser\ParsedURL')->disableOriginalConstructor()->getMock();
        $mockedParsedURL->method('getEndpoint')->willReturn($endpoint);
        $mockedParsedURL->method('getElement')->willReturn($element);
        $mockedParsedURL->method('getVersion')->willReturn($version);
        $mockedParsedURL->method('getAPIKey')->willReturn($apiKey);
        $mockedParsedURL->method('getAcceptableMIMETypes')->willReturn($acceptableMIMETypes);
        $mockedParsedURL->method('getQueryString')->willReturn($queryString);
        $mockedURLParser = $this->getMockBuilder('\LunixREST\APIRequest\URLParser\URLParser')->getMock();
        $mockedURLParser->method('parse')->willReturn($mockedParsedURL);
        return $mockedURLParser;
    }

    private function mockHeaderParser($acceptableMIMETypes, $apiKey, $contentType)
    {
        $mockedParsedHeaders = $this->getMockBuilder('\LunixREST\APIRequest\HeaderParser\ParsedHeaders')->disableOriginalConstructor()->getMock();
        $mockedParsedHeaders->method('getAcceptableMIMETypes')->willReturn($acceptableMIMETypes);
        $mockedParsedHeaders->method('getAPIKey')->willReturn($apiKey);
        $mockedParsedHeaders->method('getContentType')->willReturn($contentType);
        $mockedHeaderParser = $this->getMockBuilder('\LunixREST\APIRequest\HeaderParser\HeaderParser')->getMock();
        $mockedHeaderParser->method('parse')->willReturn($mockedParsedHeaders);
        return $mockedHeaderParser;
    }

    //TODO: test both header and url mime types are used
}
