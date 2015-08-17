<?php
namespace LunixREST\tests\AccessControl;

use LunixREST\AccessControl\AllAccessConfigurationListAccessControl;

class AllAccessConfigurationListAccessControlTest extends \PHPUnit_Framework_TestCase  {

    public function testValidateKey(){
        $accessKeys = ['public', 'notPublic', 'literallyAnyString', md5(rand())];
        $keysListIniConfig = $this->getMockBuilder('\LunixREST\Configuration\INIConfiguration')
            ->disableOriginalConstructor()
            ->getMock();
        $keysListIniConfig->method('get')->willReturn($accessKeys);

        $access = new AllAccessConfigurationListAccessControl($keysListIniConfig);

        foreach ($accessKeys as $accessKey) {
            $this->assertTrue($access->validateKey($accessKey), 'Arbitrary access keys should work as long as the access was initialized with them');
        }

        $this->assertFalse($access->validateKey(md5(rand())), 'Arbitrary access keys should not work if the access was not initialized with them');
    }

    public function testValidateAccess(){
        $accessKeys = ['public', 'notPublic', 'literallyAnyString', md5(rand())];
        $keysListIniConfig = $this->getMockBuilder('\LunixREST\Configuration\INIConfiguration')
            ->disableOriginalConstructor()
            ->getMock();
        $keysListIniConfig->method('get')->willReturn($accessKeys);

        $access = new AllAccessConfigurationListAccessControl($keysListIniConfig);

        foreach ($accessKeys as $accessKey) {
            $validRequest = $this->getMockBuilder('\LunixREST\Request\Request')
                ->disableOriginalConstructor()
                ->getMock();
            $validRequest->method('getApiKey')->willReturn($accessKey);
            $validRequest->method('getIP')->willReturn(md5(rand()));
            $validRequest->method('getMethod')->willReturn(md5(rand()));
            $validRequest->method('getEndpoint')->willReturn(md5(rand()));

            $this->assertTrue($access->validateAccess($validRequest), 'Arbitrary access keys should work as long as the access was initialized with them');
        }

        $arbitraryRequest = $this->getMockBuilder('\LunixREST\Request\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $arbitraryRequest->method('getApiKey')->willReturn(md5(rand()));
        $arbitraryRequest->method('getIP')->willReturn(md5(rand()));
        $arbitraryRequest->method('getMethod')->willReturn(md5(rand()));
        $arbitraryRequest->method('getEndpoint')->willReturn(md5(rand()));

        $this->assertFalse($access->validateAccess($arbitraryRequest), 'Arbitrary access keys should not work if the access was not initialized with them');
    }
}