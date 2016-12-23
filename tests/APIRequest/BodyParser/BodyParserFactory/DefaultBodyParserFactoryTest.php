<?php
namespace LunixREST\APIRequest\BodyParser\BodyParserFactory;

class DefaultBodyParserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowsErrorForUnknownContentType()
    {
        $bodyParserFactory = new DefaultBodyParserFactory();

        $this->expectException('\LunixREST\APIRequest\BodyParser\BodyParserFactory\Exceptions\UnknownContentTypeException');
        $bodyParserFactory->create('unknown');
    }

    public function testReturnsBodyParserForAddedContentTypeViaAdd()
    {
        $contentType = 'application/fake';
        $mockedBodyParser = $this->getMockBuilder('\LunixREST\APIRequest\BodyParser\BodyParser')->getMock();

        $bodyParserFactory = new DefaultBodyParserFactory();

        $bodyParserFactory->add($contentType, $mockedBodyParser);

        $this->assertEquals($mockedBodyParser, $bodyParserFactory->create($contentType));
    }

    public function testReturnsBodyParserForJSONContentType()
    {
        $contentType = 'application/json';

        $bodyParserFactory = new DefaultBodyParserFactory();

        $this->assertInstanceOf('\LunixREST\APIRequest\BodyParser\JSONBodyParser',
            $bodyParserFactory->create($contentType));
    }

    public function testReturnsBodyParserForURLEncodedContentType()
    {
        $contentType = 'application/x-www-form-urlencoded';

        $bodyParserFactory = new DefaultBodyParserFactory();

        $this->assertInstanceOf('\LunixREST\APIRequest\BodyParser\URLEncodedBodyParser',
            $bodyParserFactory->create($contentType));
    }
}
