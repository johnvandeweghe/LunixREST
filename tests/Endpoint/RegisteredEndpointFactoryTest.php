<?php
namespace LunixREST\Endpoint;


/**
 * Case insensitive registered endpoint factory that throws an exception on unknown endpoints
 * Class RegisteredEndpointFactory
 * @package LunixREST\Endpoint
 */
class RegisteredEndpointFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSupportedEndpointsReturnsEmptyWhenNoneRegistered()
    {
        $endpointFactory = new RegisteredEndpointFactory();

        $supportedEndpoints = $endpointFactory->getSupportedEndpoints("anyversion");

        $this->assertEmpty($supportedEndpoints);
    }

    public function testGetSupportedEndpointsReturnsAllEndpointNamesRegisteredForVersion()
    {
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $version = 2;
        $name = "theEndpoint";

        $endpointFactory = new RegisteredEndpointFactory();
        $endpointFactory->register($name, $version, $mockedEndpoint);

        $supportedEndpoints = $endpointFactory->getSupportedEndpoints($version);

        $this->assertEquals([strtolower($name)], $supportedEndpoints);
    }

    public function testGetSupportedEndpointsReturnsAllEndpointNamesRegisteredForVersionIgnoringCase()
    {
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $version = 2;
        $upperCasedName = "theEndpoint";

        $endpointFactory = new RegisteredEndpointFactory();
        $endpointFactory->register($upperCasedName, $version, $mockedEndpoint);
        $endpointFactory->register(strtolower($upperCasedName), $version, $mockedEndpoint);

        $supportedEndpoints = $endpointFactory->getSupportedEndpoints($version);

        $this->assertEquals([strtolower($upperCasedName)], $supportedEndpoints);
    }

    public function testGetEndpointThrowsExceptionForUnknownEndpoint()
    {
        $endpointFactory = new RegisteredEndpointFactory();

        $this->expectException('\LunixREST\Endpoint\Exceptions\UnknownEndpointException');

        $endpointFactory->getEndpoint('unknown', 'anyVersion');
    }

    public function testGetEndpointReturnsRegisteredEndpointForName()
    {
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $version = 2;
        $name = "theEndpoint";

        $endpointFactory = new RegisteredEndpointFactory();
        $endpointFactory->register($name, $version, $mockedEndpoint);

        $endpoint = $endpointFactory->getEndpoint($name, $version);

        $this->assertEquals($mockedEndpoint, $endpoint);
    }

    public function testGetEndpointReturnsRegisteredEndpointForNameWithAnotherRegistered()
    {
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $version = 2;
        $name = "theEndpoint";
        $mockedEndpoint2 = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $version2 = 5;
        $name2 = "theOtherEndpoint";

        $endpointFactory = new RegisteredEndpointFactory();
        $endpointFactory->register($name, $version, $mockedEndpoint);
        $endpointFactory->register($name2, $version2, $mockedEndpoint2);

        $endpoint = $endpointFactory->getEndpoint($name, $version);
        $endpoint2 = $endpointFactory->getEndpoint($name2, $version2);

        $this->assertEquals($mockedEndpoint, $endpoint);
        $this->assertEquals($mockedEndpoint2, $endpoint2);
    }

    public function testGetEndpointReturnsRegisteredEndpointForNameWhenOverwritten()
    {
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $mockedEndpoint2 = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $version = 2;
        $name = "theEndpoint";

        $endpointFactory = new RegisteredEndpointFactory();
        $endpointFactory->register($name, $version, $mockedEndpoint);
        $endpointFactory->register($name, $version, $mockedEndpoint2);

        $endpoint = $endpointFactory->getEndpoint($name, $version);

        $this->assertEquals($mockedEndpoint2, $endpoint);
    }

    public function testGetEndpointReturnsRegisteredEndpointIgnoringCase()
    {
        $mockedEndpoint = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $version = 2;
        $upperCasedName = "theEndpoint";

        $endpointFactory = new RegisteredEndpointFactory();
        $endpointFactory->register($upperCasedName, $version, $mockedEndpoint);

        $endpoint = $endpointFactory->getEndpoint(strtolower($upperCasedName), $version);

        $this->assertEquals($mockedEndpoint, $endpoint);
    }
}
