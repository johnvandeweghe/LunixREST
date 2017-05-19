<?php
namespace LunixREST\Server\AccessControl\KeyRepository;

use LunixREST\Configuration\Configuration;

/**
 * An array key repository that is read from a configuration key.
 * Class ConfigurationKeyRepository
 * @package LunixREST\Server\AccessControl\KeyRepository
 */
class ConfigurationKeyRepository extends ArrayKeyRepository
{
    /**
     * @param Configuration $config a config that has a list of valid keys in the stored $configKey
     * @param $namespace
     * @param string $configKey key to use when accessing the list of valid keys from the $config
     */
    public function __construct(Configuration $config, string $namespace, string $configKey = 'keys')
    {
        $keys = [];
        if($config->has($configKey, $namespace)){
            $configKeys = $config->get($configKey, $namespace);
            if(is_array($configKeys)) {
                $keys = $configKeys;
            }
        }

        parent::__construct($keys);
    }
}
