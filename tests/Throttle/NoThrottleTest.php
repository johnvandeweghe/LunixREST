<?php
namespace LunixREST\tests\Throttle;

use LunixREST\Throttle\NoThrottle;

class NoThrottleTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldThrottleShouldBeFalse()
    {
        $requestMock = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $throttle = new NoThrottle();

        $this->assertEquals(false, $throttle->shouldThrottle($requestMock));
    }

    public function testShouldThrottleShouldBeFalseAfterLog()
    {
        $requestMock = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $throttle = new NoThrottle();

        $throttle->logRequest($requestMock);

        $this->assertEquals(false, $throttle->shouldThrottle($requestMock));
    }

    public function testShouldThrottleShouldBeFalseAfterLotsOfLogs()
    {
        $requestMock = $this->getMockBuilder('\LunixREST\Request\Request')->disableOriginalConstructor()->getMock();
        $throttle = new NoThrottle();

        for ($i = 0; $i < 1000; $i++) {
            $throttle->logRequest($requestMock);
        }

        $this->assertEquals(false, $throttle->shouldThrottle($requestMock));
    }
}
