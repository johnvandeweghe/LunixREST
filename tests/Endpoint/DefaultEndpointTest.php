<?php
namespace LunixREST\Endpoint;

class DefaultEndpointTest extends \PHPUnit\Framework\TestCase
{
    public function testThrowsUnsupportedForGetRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->get($request);
    }

    public function testThrowsUnsupportedForGetAllRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->getAll($request);
    }

    public function testThrowsUnsupportedForPostRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->post($request);
    }

    public function testThrowsUnsupportedForPostAllRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->postAll($request);
    }

    public function testThrowsUnsupportedForPutRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->put($request);
    }

    public function testThrowsUnsupportedForPutAllRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->putAll($request);
    }

    public function testThrowsUnsupportedForPatchRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->patch($request);
    }

    public function testThrowsUnsupportedForPatchAllRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->patchAll($request);
    }

    public function testThrowsUnsupportedForOptionsRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->options($request);
    }

    public function testThrowsUnsupportedForOptionsAllRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->optionsAll($request);
    }

    public function testThrowsUnsupportedForDeleteRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->delete($request);
    }

    public function testThrowsUnsupportedForDeleteAllRequest()
    {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->deleteAll($request);
    }
}
