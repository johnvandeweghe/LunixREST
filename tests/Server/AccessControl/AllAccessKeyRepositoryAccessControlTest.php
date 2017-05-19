<?php
namespace LunixREST\Server\AccessControl;

use LunixREST\Server\AccessControl\KeyRepository\KeyRepository;

class AllAccessKeyRepositoryAccessControlTest extends KeyRepositoryAccessControlTest
{
    protected function getAccessControl(KeyRepository $keyRepository): AccessControl
    {
        return new AllAccessKeyRepositoryAccessControl($keyRepository);
    }


    public function testValidateAccessReturnsTrueIfKeyIsInRepository()
    {
        $key = "anything";
        $mockedKeyRepository = $this->getMockBuilder('\LunixREST\Server\AccessControl\KeyRepository\KeyRepository')->getMock();
        $mockedKeyRepository->method('hasKey')->with($key)->willReturn(true);
        $accessControl = $this->getAccessControl($mockedKeyRepository);
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $request->method('getAPIKey')->willReturn($key);

        $validateKey = $accessControl->validateAccess($request);

        $this->assertTrue($validateKey);
    }

    public function testValidateAccessReturnsFalseIfKeyIsNotInRepository()
    {
        $key = "anything";
        $mockedKeyRepository = $this->getMockBuilder('\LunixREST\Server\AccessControl\KeyRepository\KeyRepository')->getMock();
        $mockedKeyRepository->method('hasKey')->with($key)->willReturn(false);
        $accessControl = $this->getAccessControl($mockedKeyRepository);
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')->disableOriginalConstructor()->getMock();
        $request->method('getAPIKey')->willReturn($key);

        $validateKey = $accessControl->validateAccess($request);

        $this->assertFalse($validateKey);
    }
}
