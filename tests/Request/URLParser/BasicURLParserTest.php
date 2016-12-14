<?php
namespace LunixREST\tests\Request\URLParser;

use LunixREST\Request\URLParser\BasicURLParser;

class BasicURLParserTest extends \PHPUnit_Framework_TestCase {
    public function testCreateRequestWithInstanceFromURL() {
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestMIMEType = 'application/json';
        $requestInstance = '1000';
        $mockedMIMEProvider = $this->getMockBuilder('\LunixREST\Request\MIMEProvider')->getMock();
        $mockedMIMEProvider->method('getByFileExtension')->with($requestExtension)->willReturn($requestMIMEType);

        $urlParser = new BasicURLParser($mockedMIMEProvider);

        $parsedURL = $urlParser->parse("/$requestVersion/$requestAPIKey/$requestEndpoint/$requestInstance.$requestExtension");

        $this->assertEquals($requestVersion, $parsedURL->getVersion(), 'version should be parsed out of URLS');
        $this->assertEquals($requestAPIKey, $parsedURL->getAPIKey(), 'api key should be parsed out of URLS');
        $this->assertEquals($requestEndpoint, $parsedURL->getEndpoint(), 'endpoint should be parsed out of URLS');
        $this->assertEquals($requestInstance, $parsedURL->getInstance(), 'instance should be parsed out of URLS');
        $this->assertEquals([$requestMIMEType], $parsedURL->getAcceptableMIMETypes(), 'acceptableMIMETypes should be parsed out of URLS');
    }

    public function testCreateRequestFromInvalidURL() {
        $mockedMIMEProvider = $this->getMockBuilder('\LunixREST\Request\MIMEProvider')->getMock();
        $urlParser = new BasicURLParser($mockedMIMEProvider);

        $this->expectException('\LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException');
        $urlParser->parse("/admin");
    }

    public function testCreateRequestWithoutInstanceFromURL() {
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestMIMEType = 'application/json';
        $requestInstance = null;

        $mockedMIMEProvider = $this->getMockBuilder('\LunixREST\Request\MIMEProvider')->getMock();
        $mockedMIMEProvider->method('getByFileExtension')->with($requestExtension)->willReturn($requestMIMEType);

        $urlParser = new BasicURLParser($mockedMIMEProvider);

        $parsedURL = $urlParser->parse("/$requestVersion/$requestAPIKey/$requestEndpoint.$requestExtension");

        $this->assertEquals($requestVersion, $parsedURL->getVersion(), 'version should be parsed out of URLS');
        $this->assertEquals($requestAPIKey, $parsedURL->getAPIKey(), 'api key should be parsed out of URLS');
        $this->assertEquals($requestEndpoint, $parsedURL->getEndpoint(), 'endpoint should be parsed out of URLS');
        $this->assertEquals($requestInstance, $parsedURL->getInstance(), 'instance should be parsed out of URLS');
        $this->assertEquals([$requestMIMEType], $parsedURL->getAcceptableMIMETypes(), 'acceptableMIMETypes should be parsed out of URLS');
    }
}
