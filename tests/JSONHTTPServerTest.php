<?php
namespace LunixREST;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\NullLogger;

class JSONHTTPServerTest extends TestCase
{
    public function testRequestFactoryGetsRequestWithParsedJSON()
    {
        $testData = [
            "key" => [
                1,
                2,
                3
            ],
            "value" => false
        ];
        $mockedServer = $this->getMockBuilder('\LunixREST\Server\Server')->getMock();
        $mockedRequestFactory = $this->getMockBuilder('\LunixREST\RequestFactory\RequestFactory')->getMock();
        $mockedServerRequest = $this->buildRequestMock(json_encode($testData));
        $mockedResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')->getMock();
        $mockedResponse->method('withStatus')->willReturn($mockedResponse);
        $mockedResponse->method('withAddedHeader')->willReturn($mockedResponse);
        $mockedResponse->method('withProtocolVersion')->willReturn($mockedResponse);
        $mockedAPIRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $httpServer = new JSONHTTPServer($mockedServer, $mockedRequestFactory, new NullLogger());

        $expectedRequest = JSONHTTPServer::parseBodyAsJSON($mockedServerRequest);

        $mockedRequestFactory->expects($this->once())->method('create')->with($expectedRequest)->willReturn($mockedAPIRequest);

        /** @var ResponseInterface $mockedResponse */
        $httpServer->handleRequest($mockedServerRequest, $mockedResponse);
    }

    public function testParseBodyAsJSONParsesJSON()
    {
        $testData = '{"key":[1,2,3],"0":{"bools":[true,false]},"1":null}';
        $expectedData = [
            "key" => [
                1,
                2,
                3
            ],
            [
                "bools" => [
                    true,
                    false
                ]
            ],
            null
        ];
        $serverRequest = $this->buildRequestMock($testData);

        $parsedRequest = JSONHTTPServer::parseBodyAsJSON($serverRequest);

        $this->assertEquals($expectedData, $parsedRequest->getParsedBody());
    }

    protected function buildRequestMock($bodyString): \Psr\Http\Message\ServerRequestInterface
    {
        $temp = fopen('php://temp', 'r+');
        fwrite($temp, $bodyString);
        fseek($temp, 0);

        $mockedBody = $this->getMockBuilder('\Psr\Http\Message\StreamInterface')->getMock();
        $mockedBody->method('eof')->willReturnCallback(function() use ($temp){
            return feof($temp);
        });
        $mockedBody->method('read')->willReturnCallback(function($offset) use ($temp){
            return fread($temp, $offset);
        });
        $mockedBody->method('__toString')->willReturnCallback(function() use ($temp){
            $buffer = '';
            while(!feof($temp)){
                $buffer .= fread($temp, 1024);
            }
            return $buffer;
        });

        $mockedRequest = $this->getMockBuilder('\Psr\Http\Message\ServerRequestInterface')->getMock();
        $mockedRequest->method('getBody')->willReturn($mockedBody);
        $mockedRequest->method('withParsedBody')->willReturnCallback(function($parsedBody) use ($bodyString){
            /** @var \PHPUnit_Framework_MockObject_MockObject $newMockedRequest */
            $newMockedRequest = $this->buildRequestMock($bodyString);
            $newMockedRequest->method('getParsedBody')->willReturn($parsedBody);
            return $newMockedRequest;
        });
        $mockedRequest->method('getProtocolVersion')->willReturn(1.1);
        /** @var \Psr\Http\Message\ServerRequestInterface $mockedRequest */
        return $mockedRequest;
    }
}
