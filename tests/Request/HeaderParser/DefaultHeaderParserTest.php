<?php
namespace LunixREST\Request\HeaderParser;

class DefaultHeaderParserTest extends \PHPUnit_Framework_TestCase {
    public function testParsesAPIKeyWithDefaultKeyName() {
        $headers = [
            "X-API-KEY" => "123353245",
        ];

        $headerParser = new DefaultHeaderParser();

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['X-API-KEY'], $parsedHeaders->getAPIKey());
    }

    public function testParsesAPIKeyWithNonDefaultKeyName() {
        $headers = [
            "X-SUPER-COOL-TEST-KEY" => "123353245",
        ];

        $headerParser = new DefaultHeaderParser("X-SUPER-COOL-TEST-KEY");

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['X-SUPER-COOL-TEST-KEY'], $parsedHeaders->getAPIKey());
    }

    public function testParsesAPIKeyWithNonDefaultKeyNameAndDifferentCase() {
        $headers = [
            "X-SUPER-COOL-TEST-KEY" => "123353245",
        ];

        $headerParser = new DefaultHeaderParser("X-SUPER-cool-TEST-key");

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['X-SUPER-COOL-TEST-KEY'], $parsedHeaders->getAPIKey());
    }

    public function testParsesContentType() {
        $headers = [
            "CONTENT-TYPE" => "form/urlencoded"
        ];

        $headerParser = new DefaultHeaderParser();

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['CONTENT-TYPE'], $parsedHeaders->getContentType());
    }

    public function testParsesContentTypeLowerCase() {
        $headers = [
            "content-type" => "form/urlencoded"
        ];

        $headerParser = new DefaultHeaderParser();

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['content-type'], $parsedHeaders->getContentType());
    }

    public function testParsesHTTPAccept() {
        $headers = [
            "HTTP-ACCEPT" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
        ];

        $expectedMIMETypes = [
            "text/html",
            "application/xhtml+xml",
            "application/xml",
            "*/*"
        ];

        $headerParser = new DefaultHeaderParser();

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($expectedMIMETypes, $parsedHeaders->getAcceptableMIMETypes());
    }

}
