<?php
namespace LunixREST\APIRequest\URLParser;

class ParsedURLTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersReturnExpectedValuesForAllParameters()
    {
        $endpoint = 'helloworld';
        $element = '1000';
        $version = '1.0';
        $APIKey = 'public';
        $acceptableMIMETypes = ['application/json'];
        $queryString = 'hello=test';

        $parsedURL = new ParsedURL($endpoint, $element, $version, $APIKey, $acceptableMIMETypes, $queryString);

        $this->assertEquals($endpoint, $parsedURL->getEndpoint());
        $this->assertEquals($element, $parsedURL->getElement());
        $this->assertEquals($version, $parsedURL->getVersion());
        $this->assertEquals($APIKey, $parsedURL->getAPIKey());
        $this->assertEquals($acceptableMIMETypes, $parsedURL->getAcceptableMIMETypes());
        $this->assertEquals($queryString, $parsedURL->getQueryString());
    }
}
