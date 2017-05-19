<?php
namespace LunixREST\Server\AccessControl;

use LunixREST\Server\AccessControl\KeyRepository\KeyRepository;

/**
 * An access control that relies on a key repository. Any keys in the repository are valid.
 * Class KeyRepositoryAccessControl
 * @package LunixREST\Server\AccessControl
 */
abstract class KeyRepositoryAccessControl implements AccessControl
{
    /**
     * @var KeyRepository
     */
    private $keyRepository;

    /**
     * KeyRepositoryAccessControl constructor.
     * @param KeyRepository $keyRepository
     */
    public function __construct(KeyRepository $keyRepository)
    {
        $this->keyRepository = $keyRepository;
    }

    /**
     * @param $apiKey
     * @return bool
     */
    public function validateKey($apiKey): bool
    {
        return $this->keyRepository->hasKey($apiKey);
    }
}
