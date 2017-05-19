<?php
namespace LunixREST\Server\AccessControl\KeyRepository;

use PHPUnit\Framework\TestCase;

class ArrayKeyRepositoryTest extends TestCase
{
    protected function getKeyRepository($keys) {
        return new ArrayKeyRepository($keys);
    }

    public function testHasKeyReturnsTrueWhenKeyIsInConstructedArray()
    {
        $key = 'asdf234r24f3';
        $keys = [$key];
        $keyRepository = $this->getKeyRepository($keys);

        $hasKey = $keyRepository->hasKey($key);

        $this->assertTrue($hasKey);
    }

    public function testHasKeyReturnsFalseWhenKeyIsNotInConstructedArray()
    {
        $key = 'asdf234r24f3';
        $keys = [$key];
        $keyRepository = $this->getKeyRepository($keys);

        $hasKey = $keyRepository->hasKey("notKey");

        $this->assertFalse($hasKey);
    }

    public function testFindKeyReturnsKeyWhenKeyIsInConstructedArray()
    {
        $key = 'asdf234r24f3';
        $keys = [$key];
        $keyRepository = $this->getKeyRepository($keys);
        $expectedKeyMeta = new KeyMeta($key);

        $keyMeta = $keyRepository->findKey($key);

        $this->assertEquals($expectedKeyMeta, $keyMeta);
    }

    public function testFindKeyThrowsExceptionWhenKeyIsNotInConstructedArray()
    {
        $key = 'asdf234r24f3';
        $keys = [$key];
        $keyRepository = $this->getKeyRepository($keys);

        $this->expectException('\LunixREST\Server\AccessControl\KeyRepository\Exceptions\UnableToFindKeyException');

        $keyRepository->findKey("notKey");
    }
}
