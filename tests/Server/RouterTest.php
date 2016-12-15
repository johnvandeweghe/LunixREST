<?php
namespace LunixREST\tests\Server;

use LunixREST\Server\Router;

class RouterTest extends \PHPUnit_Framework_TestCase {
    public function testRouteCallsRequestedMethodWhenValid(){
        $method = 'getAll';
        $endpoint = 'asdasd';
        $version = '123';

        $requestMock = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $requestMock->method('getVersion')->willReturn($version);
        $requestMock->method('getEndpoint')->willReturn($endpoint);
        $requestMock->method('getMethod')->willReturn($method);

        $endpointMock = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $endpointFactoryMock = $this->getMockBuilder('\LunixREST\Endpoint\EndpointFactory')->getMock();
        $endpointFactoryMock->method('getEndpoint')->with($endpoint, $version)->willReturn($endpointMock);

        $endpointMock->expects($this->once())->method($method)->with($requestMock);

        $router = new Router($endpointFactoryMock);
        $router->route($requestMock);
    }

    public function testRouteThrowsExceptionWhenMethodIsInvalid(){
        $method = 'NotAMethodInEndpoint';
        $endpoint = 'asdasd';
        $version = '123';

        $requestMock = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $requestMock->method('getVersion')->willReturn($version);
        $requestMock->method('getEndpoint')->willReturn($endpoint);
        $requestMock->method('getMethod')->willReturn($method);

        $endpointMock = $this->getMockBuilder('\LunixREST\Endpoint\Endpoint')->getMock();
        $endpointFactoryMock = $this->getMockBuilder('\LunixREST\Endpoint\EndpointFactory')->getMock();
        $endpointFactoryMock->method('getEndpoint')->with($endpoint, $version)->willReturn($endpointMock);

        $this->expectException('LunixREST\Server\Exceptions\MethodNotFoundException');

        $router = new Router($endpointFactoryMock);
        $router->route($requestMock);
    }
}
