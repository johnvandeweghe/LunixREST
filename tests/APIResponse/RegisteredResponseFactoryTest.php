<?php
namespace LunixREST\APIResponse;

/**
 * Class RegisteredResponseFactoryTest
 * @package LunixREST\APIResponse
 */
class RegisteredResponseFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testReturnsNoSupportedMimeTypesWhenNoneRegistered()
    {
        $serializers = [];

        $responseFactory = new RegisteredResponseFactory($serializers);

        $this->assertEquals($serializers, $responseFactory->getSupportedMIMETypes());
    }

    public function testReturnsNoSupportedMimeTypesWhenDefaultConstructor()
    {
        $responseFactory = new RegisteredResponseFactory();

        $this->assertEquals([], $responseFactory->getSupportedMIMETypes());
    }

    public function testReturnsMimeTypeOfRegisteredSerializerThroughConstructor()
    {
        $mockedSerializer = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseDataSerializer')->getMock();

        $serializers = [
            'application/test' => $mockedSerializer
        ];

        $responseFactory = new RegisteredResponseFactory($serializers);

        $this->assertEquals(array_keys($serializers), $responseFactory->getSupportedMIMETypes());
    }

    public function testReturnsMimeTypeOfRegisteredSerializerLowercasedThroughConstructor()
    {
        $mockedSerializer = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseDataSerializer')->getMock();

        $serializers = [
            'application/testAAAA' => $mockedSerializer
        ];

        $responseFactory = new RegisteredResponseFactory($serializers);

        $this->assertEquals(array_map('strtolower', array_keys($serializers)), $responseFactory->getSupportedMIMETypes());
    }

    public function testReturnsMimeTypeOfRegisteredSerializer()
    {
        $mockedSerializer = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseDataSerializer')->getMock();

        $mimeType = 'application/test';
        $serializer = $mockedSerializer;

        $responseFactory = new RegisteredResponseFactory();
        $responseFactory->registerSerializer($mimeType, $serializer);

        $this->assertEquals([$mimeType], $responseFactory->getSupportedMIMETypes());
    }

    public function testReturnsMimeTypeOfRegisteredSerializerLowercased()
    {
        $mockedSerializer = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseDataSerializer')->getMock();

        $mimeType = 'application/testAAAA';
        $serializer = $mockedSerializer;

        $responseFactory = new RegisteredResponseFactory();
        $responseFactory->registerSerializer($mimeType, $serializer);

        $this->assertEquals([strtolower($mimeType)], $responseFactory->getSupportedMIMETypes());
    }

    public function testThrowsExceptionWhenAttemptingToGetResponseForUnregisteredMimeType()
    {
        $mockedResponseData = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseData')->disableOriginalConstructor()->getMock();
        $mimeType = 'application/test';

        $this->expectException('\LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException');

        $responseFactory = new RegisteredResponseFactory();
        $responseFactory->getResponse($mockedResponseData, [$mimeType]);
    }

    public function testReturnsValidResponseWhenShould()
    {
        $mockedStream = $this->getMockBuilder('\Psr\Http\Message\StreamInterface')->getMock();
        $mockedSerializer = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseDataSerializer')->getMock();
        $mockedSerializer->method('serialize')->willReturn($mockedStream);
        $mockedResponseData = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseData')->disableOriginalConstructor()->getMock();
        $mimeType = 'application/test';
        $serializer = $mockedSerializer;

        $responseFactory = new RegisteredResponseFactory();
        $responseFactory->registerSerializer($mimeType, $serializer);

        $response = $responseFactory->getResponse($mockedResponseData, [$mimeType]);

        $this->assertEquals($mockedStream, $response->getAsDataStream());
        $this->assertEquals($mimeType, $response->getMIMEType());
    }

    public function testUsesRegisteredListWhenNoAcceptableTypesPassed()
    {
        $mockedStream = $this->getMockBuilder('\Psr\Http\Message\StreamInterface')->getMock();
        $mockedSerializer = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseDataSerializer')->getMock();
        $mockedSerializer->method('serialize')->willReturn($mockedStream);
        $mockedResponseData = $this->getMockBuilder('\LunixREST\APIResponse\APIResponseData')->disableOriginalConstructor()->getMock();
        $mimeType = 'application/test';
        $serializer = $mockedSerializer;

        $responseFactory = new RegisteredResponseFactory();
        $responseFactory->registerSerializer($mimeType, $serializer);

        $response = $responseFactory->getResponse($mockedResponseData, []);

        $this->assertEquals($mockedStream, $response->getAsDataStream());
        $this->assertEquals($mimeType, $response->getMIMEType());
    }

}
