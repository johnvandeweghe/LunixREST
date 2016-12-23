<?php
namespace LunixREST\APIRequest\BodyParser\BodyParserFactory;

class RegisteredBodyParserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowsErrorForUnknownContentType()
    {
        $bodyParserFactory = new RegisteredBodyParserFactory();

        $this->expectException('\LunixREST\APIRequest\BodyParser\BodyParserFactory\Exceptions\UnknownContentTypeException');
        $bodyParserFactory->create('unknown');
    }

    public function testReturnsBodyParserForAddedContentTypeViaAdd()
    {
        $contentType = 'application/fake';
        $mockedBodyParser = $this->getMockBuilder('\LunixREST\APIRequest\BodyParser\BodyParser')->getMock();

        $bodyParserFactory = new RegisteredBodyParserFactory();

        $bodyParserFactory->add($contentType, $mockedBodyParser);

        $this->assertEquals($mockedBodyParser, $bodyParserFactory->create($contentType));
    }


    public function testReturnsBodyParserForAddedContentTypeViaConstructor()
    {
        $contentType = 'application/fake';
        $mockedBodyParser = $this->getMockBuilder('\LunixREST\APIRequest\BodyParser\BodyParser')->getMock();

        $bodyParserFactory = new RegisteredBodyParserFactory([$contentType => $mockedBodyParser]);

        $this->assertEquals($mockedBodyParser, $bodyParserFactory->create($contentType));
    }
}
