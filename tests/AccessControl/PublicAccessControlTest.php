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

        $this->assertTrue($publicAccess->validateAccess($accessKey, md5(rand()), md5(rand()), md5(rand())), 'None of the parameters except the access key should matter');
        $this->assertFalse($publicAccess->validateAccess(md5(rand()), md5(rand()), md5(rand()), md5(rand())), 'None of the parameters except the access key should matter');
    }
}