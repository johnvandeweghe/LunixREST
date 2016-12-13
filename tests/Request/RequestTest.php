<?php
namespace LunixREST\tests\Request;

use LunixREST\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {
    public function testCreateRequestWithInstanceFromConstructor() {
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestInstance = '1000';
        $requestMethod = 'get';
        $requestIP = "1.1.1.1";
        $requestHeaders = [];
        $requestDataMock = $this->getMockBuilder('\LunixREST\Request\RequestData\RequestData')->getMock();
        $urlRequestDataMock = $this->getMockBuilder('\LunixREST\Request\RequestData\RequestData')->getMock();
        $mockedMIMEProvider = $this->getMockBuilder('\LunixREST\Request\MIMEProvider')->getMock();

        $request = new Request($mockedMIMEProvider, $requestMethod, $requestHeaders, $requestDataMock, $urlRequestDataMock, $requestIP,
            $requestVersion, $requestAPIKey, $requestEndpoint, $requestExtension, $requestInstance);

        $this->assertEquals($requestVersion, $request->getVersion(), 'version should be set without a URL');
        $this->assertEquals($requestAPIKey, $request->getApiKey(), 'api key should be set without a URL');
        $this->assertEquals($requestEndpoint, $request->getEndpoint(), 'endpoint should be set without a URL');
        $this->assertEquals($requestInstance, $request->getInstance(), 'instance should be set without a URL');
        $this->assertEquals($requestExtension, $request->getExtension(), 'extension should be set without a URL');
        $this->assertEquals($requestMethod, $request->getMethod(), 'method with instance should be set without a URL');
        $this->assertEquals($requestIP, $request->getIp(), 'ip should be set without a URL');
        $this->assertEquals($requestHeaders, $request->getHeaders(), 'header should be set without a URL');
        $this->assertEquals($requestDataMock, $request->getBody(), 'body should be set without a URL');
        $this->assertEquals($urlRequestDataMock, $request->getUrlData(), 'body should be set without a URL');

    }


    public function testCreateRequestWithoutInstanceFromConstructor() {
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestInstance = null;
        $requestMethod = 'get';
        $requestIP = "1.1.1.1";
        $requestHeaders = [];
        $requestDataMock = $this->getMockBuilder('\LunixREST\Request\RequestData\RequestData')->getMock();
        $urlRequestDataMock = $this->getMockBuilder('\LunixREST\Request\RequestData\RequestData')->getMock();
        $mockedMIMEProvider = $this->getMockBuilder('\LunixREST\Request\MIMEProvider')->getMock();

        $request = new Request($mockedMIMEProvider, $requestMethod, $requestHeaders, $requestDataMock, $urlRequestDataMock, $requestIP,
            $requestVersion, $requestAPIKey, $requestEndpoint, $requestExtension, $requestInstance);

        $this->assertEquals($requestVersion, $request->getVersion(), 'version should be set without a URL');
        $this->assertEquals($requestAPIKey, $request->getApiKey(), 'api key should be set without a URL');
        $this->assertEquals($requestEndpoint, $request->getEndpoint(), 'endpoint should be set without a URL');
        $this->assertEquals($requestInstance, $request->getInstance(), 'instance should be set without a URL');
        $this->assertEquals($requestExtension, $request->getExtension(), 'extension should be set without a URL');
        $this->assertEquals($requestMethod . 'All', $request->getMethod(), 'method without instance should be set without a URL');
        $this->assertEquals($requestIP, $request->getIp(), 'ip should be set without a URL');
        $this->assertEquals($requestHeaders, $request->getHeaders(), 'header should be set without a URL');
        $this->assertEquals($requestDataMock, $request->getBody(), 'body should be set without a URL');
        $this->assertEquals($urlRequestDataMock, $request->getUrlData(), 'body should be set without a URL');
    }
}
