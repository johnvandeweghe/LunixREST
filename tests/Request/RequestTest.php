<?php
namespace LunixREST\tests\AccessControl;

use LunixREST\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {
    public function testCreateRequestWithInstanceFromURL(){
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestInstance = '1000';
        $requestMethod = 'get';

        $request = Request::createFromURL($requestMethod, [], [], '', "/$requestVersion/$requestAPIKey/$requestEndpoint/$requestInstance.$requestExtension");

        $this->assertEquals($requestVersion, $request->getVersion(), 'version should be parsed out of URLS');
        $this->assertEquals($requestAPIKey, $request->getApiKey(), 'api key should be parsed out of URLS');
        $this->assertEquals($requestEndpoint, $request->getEndpoint(), 'endpoint should be parsed out of URLS');
        $this->assertEquals($requestInstance, $request->getInstance(), 'instance should be parsed out of URLS');
        $this->assertEquals($requestExtension, $request->getExtension(), 'extension should be parsed out of URLS');
        $this->assertEquals($requestMethod, $request->getMethod(), 'method with instance should be parsed out of URLS');
    }

    public function testCreateRequestWithoutInstanceFromURL(){
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestInstance = null;
        $requestMethod = 'get';

        $request = Request::createFromURL($requestMethod, [], [], '', "/$requestVersion/$requestAPIKey/$requestEndpoint.$requestExtension");

        $this->assertEquals($requestVersion, $request->getVersion(), 'version should be parsed out of URLS');
        $this->assertEquals($requestAPIKey, $request->getApiKey(), 'api key should be parsed out of URLS');
        $this->assertEquals($requestEndpoint, $request->getEndpoint(), 'endpoint should be parsed out of URLS');
        $this->assertEquals($requestInstance, $request->getInstance(), 'instance should be parsed out of URLS');
        $this->assertEquals($requestExtension, $request->getExtension(), 'extension should be parsed out of URLS');
        $this->assertEquals($requestMethod . 'All', $request->getMethod(), 'method without instance should be parsed out of URLS');
    }


    public function testCreateRequestWithInstanceFromConstructor() {
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestInstance = '1000';
        $requestMethod = 'get';

        $request = new Request($requestMethod, [], [], '', $requestVersion, $requestAPIKey, $requestEndpoint, $requestExtension, $requestInstance);

        $this->assertEquals($requestVersion, $request->getVersion(), 'version should be set without a URL');
        $this->assertEquals($requestAPIKey, $request->getApiKey(), 'api key should be set without a URL');
        $this->assertEquals($requestEndpoint, $request->getEndpoint(), 'endpoint should be set without a URL');
        $this->assertEquals($requestInstance, $request->getInstance(), 'instance should be set without a URL');
        $this->assertEquals($requestExtension, $request->getExtension(), 'extension should be set without a URL');
        $this->assertEquals($requestMethod, $request->getMethod(), 'method with instance should be set without a URL');
    }


    public function testCreateRequestWithoutInstanceFromConstructor() {
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestInstance = null;
        $requestMethod = 'get';

        $request = new Request($requestMethod, [], [], '', $requestVersion, $requestAPIKey, $requestEndpoint, $requestExtension, $requestInstance);

        $this->assertEquals($requestVersion, $request->getVersion(), 'version should be set without a URL');
        $this->assertEquals($requestAPIKey, $request->getApiKey(), 'api key should be set without a URL');
        $this->assertEquals($requestEndpoint, $request->getEndpoint(), 'endpoint should be set without a URL');
        $this->assertEquals($requestInstance, $request->getInstance(), 'instance should be set without a URL');
        $this->assertEquals($requestExtension, $request->getExtension(), 'extension should be set without a URL');
        $this->assertEquals($requestMethod . 'All', $request->getMethod(), 'method without instance should be set without a URL');
    }
}
