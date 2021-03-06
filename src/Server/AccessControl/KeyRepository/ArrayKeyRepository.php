<?php
namespace LunixREST\Server\AccessControl\KeyRepository;

use LunixREST\Server\AccessControl\KeyRepository\Exceptions\UnableToFindKeyException;

/**
 * A key repository based on a provided array.
 * Class ArrayKeyRepository
 * @package LunixREST\Server\AccessControl\KeyRepository
 */
class ArrayKeyRepository implements KeyRepository
{
    /**
     * @var
     */
    private $arrayOfKeys;

    /**
     * ArrayKeyRepository constructor.
     * @param $arrayOfKeys
     */
    public function __construct($arrayOfKeys)
    {
        $this->arrayOfKeys = $arrayOfKeys;
    }

    /**
     * @param string $key
     * @return KeyMeta
     * @throws UnableToFindKeyException
     */
    public function findKey(string $key): KeyMeta
    {
        if($this->hasKey($key)) {
            return new KeyMeta($key);
        } else {
            throw new UnableToFindKeyException("Unable to find API key in array.");
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key): bool
    {
        return in_array($key, $this->arrayOfKeys);
    }
}
