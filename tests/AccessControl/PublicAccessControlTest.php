<?php
namespace LunixREST\tests\AccessControl;

use LunixREST\AccessControl\PublicAccessControl;

class PublicAccessControlTest extends \PHPUnit_Framework_TestCase  {

    public function testValidateAccess(){
        $accessKey = 'public';

        $publicAccess = new PublicAccessControl($accessKey);
        $this->assertTrue($publicAccess->validateKey($accessKey), 'Arbitrary access keys should work as long as the public access was initialized with them');
    }
}