<?php
namespace LunixREST\tests\AccessControl;

use LunixREST\AccessControl\OneKeyAccessControl;
use LunixREST\AccessControl\PublicAccessControl;

class PublicAccessControlTest extends \PHPUnit_Framework_TestCase  {

    public function testValidateKeyWhenValid() {
        $publicAccess = new PublicAccessControl();
        $this->assertTrue($publicAccess->validateKey(null));
    }

    public function testValidateAccessWhenValid() {
        $publicAccess = new PublicAccessControl();

        $requestMock = $this->getMockBuilder('\LunixREST\Request\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->method('getApiKey')->willReturn(null);

        $this->assertTrue($publicAccess->validateAccess($requestMock));
    }
}
