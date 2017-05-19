<?php
namespace LunixREST\Server\AccessControl\KeyRepository;

use LunixREST\Server\AccessControl\KeyRepository\Exceptions\UnableToFindKeyException;

/**
 * Interface KeyRepository
 * @package LunixREST\ServerAccessControl\KeyRepository
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
