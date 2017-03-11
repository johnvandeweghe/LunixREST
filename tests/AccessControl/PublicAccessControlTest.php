<?php
namespace LunixREST\AccessControl;

class PublicAccessControlTest extends \PHPUnit\Framework\TestCase
{

    public function testValidateKeyWhenValid()
    {
        $publicAccess = new PublicAccessControl();
        $this->assertTrue($publicAccess->validateKey(null));
    }

    public function testValidateAccessWhenValid()
    {
        $publicAccess = new PublicAccessControl();

        $requestMock = $this->getMockBuilder('\LunixREST\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->method('getApiKey')->willReturn(null);

        $this->assertTrue($publicAccess->validateAccess($requestMock));
    }
}
