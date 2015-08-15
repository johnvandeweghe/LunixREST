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

    protected $configKey;

    public function __construct(Configuration $config, $configKey = 'keys'){
        $this->config = $config;
        $this->configKey = $configKey;
    }

    /**
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function validateAccess(Request $request){
        return $this->validateKey($request->getApiKey());
    }

    public function validateKey($apiKey){
        return in_array($apiKey, $this->config->get($this->configKey));
    }
}