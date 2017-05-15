<?php
namespace LunixREST\RequestFactory\URLParser\RegexURLParser;

use LunixREST\RequestFactory\URLParser\Exceptions\UnableToProvideMIMEException;
use PHPUnit\Framework\TestCase;

class RegexURLParserTest extends TestCase
{
    public function testConstructionThrowsExceptionOnInvalidRegex() {
        $regex = '/asdasda';

        $this->expectException('\LunixREST\RequestFactory\URLParser\RegexURLParser\Exceptions\InvalidRegexPatternException');

        new RegexURLParser($regex);
    }

    public function testGetPatternReturnsConstructedPattern() {
        $regex = '/asdasda/';
        $urlParser = new RegexURLParser($regex);

        $pattern = $urlParser->getPattern();

        $this->assertEquals($regex, $pattern);
    }

    public function testParseThrowsInvalidRequestURLExceptionOnNonMatchingURL() {
        $regex = '/asdasda/';
        $url = '/api/v3/n';
        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();
        $mockedURI->method('getPath')->willReturn($url);
        $urlParser = new RegexURLParser($regex);

        $this->expectException('\LunixREST\RequestFactory\URLParser\Exceptions\InvalidRequestURLException');

        $urlParser->parse($mockedURI);
    }

    public function testParseThrowsInvalidRequestURLExceptionOnMissingEndpointCaptureGroup() {
        $regex = '/.*/';
        $url = '/asdasda';
        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();
        $mockedURI->method('getPath')->willReturn($url);
        $urlParser = new RegexURLParser($regex);

        $this->expectException('\LunixREST\RequestFactory\URLParser\Exceptions\InvalidRequestURLException');

        $urlParser->parse($mockedURI);
    }

    public function testParseReturnsExpectedParsedURLWhenEndpointFound() {
        $regex = '@^/(?<endpoint>[^/]*)/$@';
        $endpoint = "messages";
        $url = "/$endpoint/";
        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();
        $mockedURI->method('getPath')->willReturn($url);
        $urlParser = new RegexURLParser($regex);

        $parsedUrl = $urlParser->parse($mockedURI);

        $this->assertEquals($endpoint, $parsedUrl->getEndpoint());
    }

    public function testParseReturnsExpectedParsedURLWhenEndpointAndVersionFound() {
        $regex = '@^/(?<version>[^/]*)/(?<endpoint>[^/]*)/$@';
        $version = "v43";
        $endpoint = "messages";
        $url = "/$version/$endpoint/";
        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();
        $mockedURI->method('getPath')->willReturn($url);
        $urlParser = new RegexURLParser($regex);

        $parsedUrl = $urlParser->parse($mockedURI);

        $this->assertEquals($endpoint, $parsedUrl->getEndpoint());
        $this->assertEquals($version, $parsedUrl->getVersion());
    }

    public function testParseReturnsExpectedParsedURLWhenEndpointAndVersionAndAPIKeyFound() {
        $regex = '@^/(?<apiKey>[^/]*)/(?<version>[^/]*)/(?<endpoint>[^/]*)/$@';
        $apiKey = "dsfgdf6g4dfg6874687";
        $version = "v43";
        $endpoint = "messages";
        $url = "/$apiKey/$version/$endpoint/";
        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();
        $mockedURI->method('getPath')->willReturn($url);
        $urlParser = new RegexURLParser($regex);

        $parsedUrl = $urlParser->parse($mockedURI);

        $this->assertEquals($endpoint, $parsedUrl->getEndpoint());
        $this->assertEquals($version, $parsedUrl->getVersion());
        $this->assertEquals($apiKey, $parsedUrl->getApiKey());
    }

    public function testParseThrowsInvalidURLExceptionWhenAcceptableExtensionIsFoundWithNoMimeProvider()
    {
        $regex = '@^/(?<endpoint>[^/]*)\.(?<acceptableExtension>[^/]*)$@';
        $acceptableExtension = "json";
        $endpoint = "messages";
        $url = "/$endpoint.$acceptableExtension";
        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();
        $mockedURI->method('getPath')->willReturn($url);
        $urlParser = new RegexURLParser($regex);

        $this->expectException('\LunixREST\RequestFactory\URLParser\Exceptions\InvalidRequestURLException');

        $urlParser->parse($mockedURI);
    }

    public function testParseThrowsInvalidURLExceptionWhenAcceptableExtensionIsFoundAndMimeProviderThrowsUnableToProvideMIMEException() {
        $regex = '@^/(?<endpoint>[^/]*)\.(?<acceptableExtension>[^/]*)$@';
        $acceptableExtension = "json";
        $endpoint = "messages";
        $url = "/$endpoint.$acceptableExtension";
        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();
        $mockedURI->method('getPath')->willReturn($url);
        $mockedMimeProvider = $this->getMockBuilder('\LunixREST\RequestFactory\URLParser\MIMEProvider')->getMock();
        $mockedMimeProvider->method('provideMIME')
            ->willThrowException(new UnableToProvideMIMEException());
        $urlParser = new RegexURLParser($regex, $mockedMimeProvider);

        $this->expectException('\LunixREST\RequestFactory\URLParser\Exceptions\InvalidRequestURLException');

        $urlParser->parse($mockedURI);
    }

    public function testParseReturnsExpectedParsedURLWhenEndpointAndAcceptableExtensionAreFound() {
        $regex = '@^/(?<endpoint>[^/]*)\.(?<acceptableExtension>[^/]*)$@';
        $acceptableExtension = "json";
        $acceptableMimeType = "application/json";
        $endpoint = "messages";
        $url = "/$endpoint.$acceptableExtension";
        $mockedURI = $this->getMockBuilder('\Psr\Http\Message\UriInterface')->getMock();
        $mockedURI->method('getPath')->willReturn($url);
        $mockedMimeProvider = $this->getMockBuilder('\LunixREST\RequestFactory\URLParser\MIMEProvider')->getMock();
        $mockedMimeProvider->method('provideMIME')->willReturn($acceptableMimeType);
        $urlParser = new RegexURLParser($regex, $mockedMimeProvider);

        $parsedUrl = $urlParser->parse($mockedURI);

        $this->assertEquals([$acceptableMimeType], $parsedUrl->getAcceptableMIMETypes());
    }
}
