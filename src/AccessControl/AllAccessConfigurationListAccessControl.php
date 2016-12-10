<?php
namespace LunixREST\AccessControl;
use LunixREST\Configuration\Configuration;
use LunixREST\Request\Request;

/**
 * Class AllAccessListAccessControl
 * @package LunixREST\AccessControl
 */
class AllAccessConfigurationListAccessControl implements AccessControl {
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var string
     */
    protected $configKey;

    /**
     * @param Configuration $config a config that has a list of valid keys in the stored $configKey
     * @param string $configKey key to use when accessing the list of valid keys from the $config
     */
    public function __construct(Configuration $config, $configKey = 'keys'){
        $this->config = $config;
        $this->configKey = $configKey;
    }

    /**
     * @param \LunixREST\Request\Request $request
     * @return bool true if this key is valid
     */
    public function validateAccess(Request $request){
        return $this->validateKey($request->getApiKey());
    }

    /**
     * @param $apiKey
     * @return bool true if the key is found inside of the array returned by the config when $config->get is called with the key from the constructor
     */
    public function validateKey($apiKey){
        return in_array($apiKey, $this->config->get($this->configKey));
    }
}