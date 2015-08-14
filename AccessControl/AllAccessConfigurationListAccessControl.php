<?php
namespace LunixREST\AccessControl;
use LunixREST\Configuration\Configuration;

/**
 * Class AllAccessListAccessControl
 * @package LunixREST\AccessControl
 */
class AllAccessConfigurationListAccessControl implements AccessControl {
    /**
     * @var Configuration
     */
    protected $config;

    protected $configKey;

    public function __construct(Configuration $config, $configKey = 'keys'){
        $this->config = $config;
        $this->configKey = $configKey;
    }

    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @param $instance
     * @return bool
     */
    public function validateAccess($apiKey, $endPoint, $method, $instance){
        return $this->validateKey($apiKey);
    }

    public function validateKey($apiKey){
        return in_array($apiKey, $this->config->get($this->configKey));
    }
}