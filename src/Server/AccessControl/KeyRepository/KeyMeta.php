<?php
namespace LunixREST\Server\AccessControl\KeyRepository;

/**
 * Class KeyMeta
 * @package LunixREST\Server\AccessControl\KeyRepository
 */
class KeyMeta {
    /**
     * @var string
     */
    private $key;

    /**
     * KeyMeta constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
