<?php
namespace LunixREST\tests\AccessControl;

use LunixREST\AccessControl\PublicAccessControl;

class PublicAccessControlTest extends \PHPUnit_Framework_TestCase  {

    public function testValidateKey(){
        $accessKeys = ['public', 'notPublic', 'literallyAnyString', md5(rand())];

        foreach ($accessKeys as $accessKey) {
            $publicAccess = new PublicAccessControl($accessKey);
            $this->assertTrue($publicAccess->validateKey($accessKey), 'Arbitrary access keys should work as long as the public access was initialized with them');
        }

        $publicAccess = new PublicAccessControl('not an md5');
        $this->assertFalse($publicAccess->validateKey(md5(rand())), 'Arbitrary access keys should not work if the public access was not initialized with them');
    }

    public function testValidateAccess(){
        $accessKey = md5(rand());

        $publicAccess = new PublicAccessControl($accessKey);

        $validRequest = $this->getMockBuilder('\LunixREST\Request\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $validRequest->method('getApiKey')->willReturn($accessKey);


        $arbitraryRequest = $this->getMockBuilder('\LunixREST\Request\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $arbitraryRequest->method('getApiKey')->willReturn(md5(rand()));

        $this->assertTrue($publicAccess->validateAccess($validRequest), 'None of the parameters except the access key should matter');
        $this->assertFalse($publicAccess->validateAccess($arbitraryRequest), 'None of the parameters except the access key should matter');
    }
}