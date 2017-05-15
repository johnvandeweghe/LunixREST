<?php
namespace LunixREST\Server\Throttle;


class NoThrottleTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldThrottleShouldBeFalse()
    {
        $requestMock = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $throttle = new NoThrottle();

        $this->assertEquals(false, $throttle->shouldThrottle($requestMock));
    }

    public function testShouldThrottleShouldBeFalseAfterLog()
    {
        $requestMock = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $throttle = new NoThrottle();

        $throttle->logRequest($requestMock);

        $this->assertEquals(false, $throttle->shouldThrottle($requestMock));
    }

    public function testShouldThrottleShouldBeFalseAfterLotsOfLogs()
    {
        $requestMock = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $throttle = new NoThrottle();

        for ($i = 0; $i < 1000; $i++) {
            $throttle->logRequest($requestMock);
        }

        $this->assertEquals(false, $throttle->shouldThrottle($requestMock));
    }
}
