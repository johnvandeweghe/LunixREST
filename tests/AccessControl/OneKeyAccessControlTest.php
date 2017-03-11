<?php
namespace LunixREST\AccessControl;

class OneKeyAccessControlTest extends \PHPUnit\Framework\TestCase
{

    public function testValidateKeyWhenValid()
    {
        $accessKey = md5(rand());

        $oneKeyAccess = new OneKeyAccessControl($accessKey);
        $this->assertTrue($oneKeyAccess->validateKey($accessKey));
    }

    public function testValidateKeyWhenInvalid()
    {
        $accessKey = md5(rand());
        $notAccessKey = "asd";

        $oneKeyAccess = new OneKeyAccessControl($accessKey);
        $this->assertFalse($oneKeyAccess->validateKey($notAccessKey));
    }

    public function testValidateAccessWhenValid()
    {
        $accessKey = md5(rand());

        $oneKeyAccess = new OneKeyAccessControl($accessKey);

        $requestMock = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->method('getApiKey')->willReturn($accessKey);

        $this->assertTrue($oneKeyAccess->validateAccess($requestMock));
    }

    public function testValidateAccessWhenInvalid()
    {
        $accessKey = md5(rand());
        $notAccessKey = "asd";

        $oneKeyAccess = new OneKeyAccessControl($accessKey);

        $requestMock = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->method('getApiKey')->willReturn($notAccessKey);

        $this->assertFalse($oneKeyAccess->validateAccess($requestMock));
    }
}
