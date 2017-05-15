<?php
namespace LunixREST\Server\AccessControl;

class AllAccessListAccessControlTest extends \PHPUnit\Framework\TestCase
{

    public function testValidateKey()
    {
        $accessKeys = ['public', 'notPublic', 'literallyAnyString', md5(rand())];
        $access = new AllAccessListAccessControl($accessKeys);

        foreach ($accessKeys as $accessKey) {
            $this->assertTrue($access->validateKey($accessKey),
                'Arbitrary access keys should work as long as the access was initialized with them');
        }

        $this->assertFalse($access->validateKey(md5(rand())),
            'Arbitrary access keys should not work if the access was not initialized with them');
    }

    public function testValidateAccess()
    {
        $accessKeys = ['public', 'notPublic', 'literallyAnyString', md5(rand())];

        $access = new AllAccessListAccessControl($accessKeys);

        foreach ($accessKeys as $accessKey) {
            $validRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
                ->disableOriginalConstructor()
                ->getMock();
            $validRequest->method('getApiKey')->willReturn($accessKey);

            $this->assertTrue($access->validateAccess($validRequest),
                'Arbitrary access keys should work as long as the access was initialized with them');
        }

        $arbitraryRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()
            ->getMock();
        $arbitraryRequest->method('getApiKey')->willReturn(md5(rand()));

        $this->assertFalse($access->validateAccess($arbitraryRequest),
            'Arbitrary access keys should not work if the access was not initialized with them');
    }
}
