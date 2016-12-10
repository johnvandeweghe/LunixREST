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
    }
}
