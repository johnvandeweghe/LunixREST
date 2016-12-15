<?php
namespace LunixREST\tests\AccessControl;

use LunixREST\AccessControl\OneKeyAccessControl;

class OneKeyAccessControlTest extends \PHPUnit_Framework_TestCase  {

    public function testValidateKeyWhenValid() {
        $accessKey = md5(rand());

        $publicAccess = new OneKeyAccessControl($accessKey);
        $this->assertTrue($publicAccess->validateKey($accessKey));
    }
    public function testValidateKeyWhenInvalid(){
        $accessKey = md5(rand());
        $notAccessKey = "asd";

        $publicAccess = new OneKeyAccessControl($accessKey);
        $this->assertFalse($publicAccess->validateKey($notAccessKey));
    }

    public function testValidateAccessWhenValid() {
        $accessKey = md5(rand());

        $publicAccess = new OneKeyAccessControl($accessKey);

        $requestMock = $this->getMockBuilder('\LunixREST\Request\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->method('getApiKey')->willReturn($accessKey);

        $this->assertTrue($publicAccess->validateAccess($requestMock));
    }

    public function testValidateAccessWhenInvalid() {
        $accessKey = md5(rand());
        $notAccessKey = "asd";

        $publicAccess = new OneKeyAccessControl($accessKey);

        $requestMock = $this->getMockBuilder('\LunixREST\Request\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->method('getApiKey')->willReturn($notAccessKey);

        $this->assertFalse($publicAccess->validateAccess($requestMock));
    }
}
