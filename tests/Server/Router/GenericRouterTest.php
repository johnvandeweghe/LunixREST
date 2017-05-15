<?php
namespace LunixREST\Server\Router;

class GenericRouterTest extends \PHPUnit\Framework\TestCase
{
    public function testRouteCallsRequestedMethodWithAllWhenValid()
    {
        $method = 'get';
        $element = 123;
        $endpoint = 'asdasd';
        $version = '123';

        $requestMock = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $requestMock->method('getVersion')->willReturn($version);
        $requestMock->method('getEndpoint')->willReturn($endpoint);
        $requestMock->method('getMethod')->willReturn($method);
        $requestMock->method('getElement')->willReturn($element);

        $endpointMock = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\Endpoint')->getMock();
        $endpointFactoryMock = $this->getMockBuilder('\LunixREST\Server\Router\EndpointFactory\EndpointFactory')->getMock();
        $endpointFactoryMock->method('getEndpoint')->with($endpoint, $version)->willReturn($endpointMock);

        $endpointMock->expects($this->once())->method($method)->with($requestMock);

        $router = new GenericRouter($endpointFactoryMock);
        $router->route($requestMock);
    }

    public function testRouteCallsRequestedMethodWithoutAllWhenValid()
    {
        $method = 'get';
        $element = null;
        $endpoint = 'asdasd';
        $version = '123';

        $requestMock = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $requestMock->method('getVersion')->willReturn($version);
        $requestMock->method('getEndpoint')->willReturn($endpoint);
        $requestMock->method('getMethod')->willReturn($method);
        $requestMock->method('getElement')->willReturn($element);

        $endpointMock = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\Endpoint')->getMock();
        $endpointFactoryMock = $this->getMockBuilder('\LunixREST\Server\Router\EndpointFactory\EndpointFactory')->getMock();
        $endpointFactoryMock->method('getEndpoint')->with($endpoint, $version)->willReturn($endpointMock);

        $endpointMock->expects($this->once())->method($method . "All")->with($requestMock);

        $router = new GenericRouter($endpointFactoryMock);
        $router->route($requestMock);
    }

    public function testRouteThrowsExceptionWhenMethodIsInvalid()
    {
        $method = 'NotAMethodInEndpoint';
        $endpoint = 'asdasd';
        $version = '123';

        $requestMock = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $requestMock->method('getVersion')->willReturn($version);
        $requestMock->method('getEndpoint')->willReturn($endpoint);
        $requestMock->method('getMethod')->willReturn($method);

        $endpointMock = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\Endpoint')->getMock();
        $endpointFactoryMock = $this->getMockBuilder('\LunixREST\Server\Router\EndpointFactory\EndpointFactory')->getMock();
        $endpointFactoryMock->method('getEndpoint')->with($endpoint, $version)->willReturn($endpointMock);

        $this->expectException('LunixREST\Server\Router\Exceptions\MethodNotFoundException');

        $router = new GenericRouter($endpointFactoryMock);
        $router->route($requestMock);
    }
}
