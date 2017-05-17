<?php
namespace LunixREST\AccessControl\KeyRepository;

use LunixREST\AccessControl\KeyRepository\Exceptions\UnableToFindKeyException;

/**
 * Interface KeyRepository
 * @package LunixREST\AccessControl\KeyRepository
 */
interface KeyRepository {
    /**
     * @param string $key
     * @return KeyMeta
     * @throws UnableToFindKeyException
     */
    public function findKey(string $key): KeyMeta;

    /**
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key): bool;
}
