<?php
namespace LunixREST\Configuration;

/**
 * Interface Configuration
 * @package LunixREST\Configuration
 */
interface Configuration
{
    /**
     * @param $key
     * @param null|string $namespace
     * @return mixed
     */
    public function get($key, $namespace);

    /**
     * @param $key
     * @param null $namespace
     * @return bool
     */
    public function has($key, $namespace): bool;
}
