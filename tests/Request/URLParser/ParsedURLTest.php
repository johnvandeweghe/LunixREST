<?php
namespace LunixREST\tests\Request\URLParser;

use LunixREST\Request\URLParser\ParsedURL;

class ParsedURLTest extends \PHPUnit_Framework_TestCase {
    public function testGettersReturnExpectedValuesForAllParameters() {
        $mockedRequestData = $this->getMockBuilder('\LunixREST\Request\RequestData\RequestData')->getMock();
        $version = '1.0';
        $APIKey = 'public';
        $endpoint = 'helloworld';
        $acceptableMIMETypes = ['application/json'];
        $instance = '1000';

        $parsedURL = new ParsedURL($mockedRequestData, $version, $APIKey, $endpoint, $acceptableMIMETypes, $instance);

        $this->assertEquals($mockedRequestData, $parsedURL->getRequestData());
        $this->assertEquals($version, $parsedURL->getVersion());
        $this->assertEquals($APIKey, $parsedURL->getAPIKey());
        $this->assertEquals($endpoint, $parsedURL->getEndpoint());
        $this->assertEquals($acceptableMIMETypes, $parsedURL->getAcceptableMIMETypes());
        $this->assertEquals($instance, $parsedURL->getInstance());
    }
}
