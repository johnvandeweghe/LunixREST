<?php
namespace LunixREST\tests\Request\URLParser;

use LunixREST\Request\URLParser\BasicURLParser;

class BasicURLParserTest extends \PHPUnit_Framework_TestCase {
    public function testCreateRequestWithInstanceFromURL() {
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestInstance = '1000';

        $urlParser = new BasicURLParser();

        $parsedURL = $urlParser->parse("/$requestVersion/$requestAPIKey/$requestEndpoint/$requestInstance.$requestExtension");

        $this->assertEquals($requestVersion, $parsedURL->getVersion(), 'version should be parsed out of URLS');
        $this->assertEquals($requestAPIKey, $parsedURL->getApiKey(), 'api key should be parsed out of URLS');
        $this->assertEquals($requestEndpoint, $parsedURL->getEndpoint(), 'endpoint should be parsed out of URLS');
        $this->assertEquals($requestInstance, $parsedURL->getInstance(), 'instance should be parsed out of URLS');
        $this->assertEquals($requestExtension, $parsedURL->getExtension(), 'extension should be parsed out of URLS');
    }

    public function testCreateRequestFromInvalidURL() {
        $urlParser = new BasicURLParser();

        $this->expectException('\LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException');
        $urlParser->parse("/admin");
    }

    public function testCreateRequestWithoutInstanceFromURL() {
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestEndpoint = 'helloworld';
        $requestExtension = 'json';
        $requestInstance = null;

        $urlParser = new BasicURLParser();

        $parsedURL = $urlParser->parse("/$requestVersion/$requestAPIKey/$requestEndpoint.$requestExtension");

        $this->assertEquals($requestVersion, $parsedURL->getVersion(), 'version should be parsed out of URLS');
        $this->assertEquals($requestAPIKey, $parsedURL->getApiKey(), 'api key should be parsed out of URLS');
        $this->assertEquals($requestEndpoint, $parsedURL->getEndpoint(), 'endpoint should be parsed out of URLS');
        $this->assertEquals($requestInstance, $parsedURL->getInstance(), 'instance should be parsed out of URLS');
        $this->assertEquals($requestExtension, $parsedURL->getExtension(), 'extension should be parsed out of URLS');
    }
}
