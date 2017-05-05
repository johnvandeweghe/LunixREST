<?php
namespace LunixREST\APIRequest\URLParser\RegexURLParser;

use PHPUnit\Framework\TestCase;

class RegexURLParserTest extends TestCase
{
    public function testConstructionThrowsExceptionOnInvalidRegex() {
        $regex = '/asdasda';

        $this->expectException('\LunixREST\APIRequest\URLParser\RegexURLParser\Exceptions\InvalidRegexPatternException');

        new RegexURLParser($regex);
    }
    
    public function testGetPatternReturnsConstructedPattern() {
        $regex = '/asdasda/';
        $urlParser = new RegexURLParser($regex);

        $pattern = $urlParser->getPattern();

        $this->assertEquals($regex, $pattern);
    }
}
