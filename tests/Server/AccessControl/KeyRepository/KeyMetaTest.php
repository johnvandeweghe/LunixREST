<?php
namespace LunixREST\Server\AccessControl\KeyRepository;

use PHPUnit\Framework\TestCase;

class KeyMetaTest extends TestCase
{
    public function testGetApiKeyReturnsConstructedKey() {
        $key = "Asdsdf245234";
        $keyMeta = new KeyMeta($key);

        $returnedKey = $keyMeta->getKey();

        $this->assertEquals($key, $returnedKey);
    }
}
