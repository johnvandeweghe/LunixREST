<?php
namespace LunixREST\Server\AccessControl;

use LunixREST\Server\AccessControl\KeyRepository\KeyRepository;
use PHPUnit\Framework\TestCase;

class KeyRepositoryAccessControlTest extends TestCase
{
    /**
     * @param KeyRepository $keyRepository
     * @return AccessControl
     */
    protected function getAccessControl(KeyRepository $keyRepository): AccessControl
    {
        return $this->getMockBuilder('\LunixREST\Server\AccessControl\KeyRepositoryAccessControl')->setConstructorArgs([$keyRepository])
            ->getMockForAbstractClass();
    }

    public function testValidateKeyReturnsTrueIfKeyIsInRepository()
    {
        $key = "anything";
        $mockedKeyRepository = $this->getMockBuilder('\LunixREST\Server\AccessControl\KeyRepository\KeyRepository')->getMock();
        $mockedKeyRepository->method('hasKey')->with($key)->willReturn(true);
        $accessControl = $this->getAccessControl($mockedKeyRepository);

        $validateKey = $accessControl->validateKey($key);

        $this->assertTrue($validateKey);
    }

    public function testValidateKeyReturnsFalseIfKeyIsNotInRepository()
    {
        $key = "anything";
        $mockedKeyRepository = $this->getMockBuilder('\LunixREST\Server\AccessControl\KeyRepository\KeyRepository')->getMock();
        $mockedKeyRepository->method('hasKey')->with($key)->willReturn(false);
        $accessControl = $this->getAccessControl($mockedKeyRepository);

        $validateKey = $accessControl->validateKey($key);

        $this->assertFalse($validateKey);
    }
}
