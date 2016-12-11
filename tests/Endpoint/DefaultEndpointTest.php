<?php
namespace LunixREST\tests\Endpoint;

use LunixREST\Endpoint\DefaultEndpoint;

class DefaultEndpointTest extends \PHPUnit_Framework_TestCase {
    public function testThrowsUnsupportedForAllRequests() {
        $defaultEndpoint = new DefaultEndpoint();
        $request = $this->getMockBuilder('\LunixREST\Request\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $this->setExpectedException('LunixREST\Endpoint\Exceptions\UnsupportedMethodException');
        $defaultEndpoint->get($request);
        $defaultEndpoint->getAll($request);
        $defaultEndpoint->post($request);
        $defaultEndpoint->postAll($request);
        $defaultEndpoint->put($request);
        $defaultEndpoint->putAll($request);
        $defaultEndpoint->options($request);
        $defaultEndpoint->optionsAll($request);
        $defaultEndpoint->delete($request);
        $defaultEndpoint->deleteAll($request);
    }
}
