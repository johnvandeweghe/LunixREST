<?php
namespace LunixREST\APIRequest\HeaderParser;

class DefaultHeaderParserTest extends \PHPUnit\Framework\TestCase
{
    public function testParsesAPIKeyWithDefaultKeyName()
    {
        $headers = [
            "X-API-KEY" => ["123353245"],
        ];

        $headerParser = new DefaultHeaderParser();

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['X-API-KEY'][0], $parsedHeaders->getAPIKey());
    }

    public function testParsesAPIKeyWithNonDefaultKeyName()
    {
        $headers = [
            "X-SUPER-COOL-TEST-KEY" => ["123353245"],
        ];

        $headerParser = new DefaultHeaderParser("X-SUPER-COOL-TEST-KEY");

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['X-SUPER-COOL-TEST-KEY'][0], $parsedHeaders->getAPIKey());
    }

    public function testParsesAPIKeyWithNonDefaultKeyNameAndDifferentCase()
    {
        $headers = [
            "X-SUPER-COOL-TEST-KEY" => ["123353245"],
        ];

        $headerParser = new DefaultHeaderParser("X-SUPER-cool-TEST-key");

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['X-SUPER-COOL-TEST-KEY'][0], $parsedHeaders->getAPIKey());
    }

    public function testParsesContentType()
    {
        $headers = [
            "CONTENT-TYPE" => ["form/urlencoded"]
        ];

        $headerParser = new DefaultHeaderParser();

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['CONTENT-TYPE'][0], $parsedHeaders->getContentType());
    }

    public function testParsesContentTypeLowerCase()
    {
        $headers = [
            "content-type" => ["form/urlencoded"]
        ];

        $headerParser = new DefaultHeaderParser();

        $parsedHeaders = $headerParser->parse($headers);

        $this->assertEquals($headers['content-type'][0], $parsedHeaders->getContentType());
    }

    public function testParsesHTTPAccept()
    {
        $headers = [
            "HTTP-ACCEPT" => ["text/html","application/xhtml+xml","application/xml;q=0.9","*/*;q=0.8"]
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
