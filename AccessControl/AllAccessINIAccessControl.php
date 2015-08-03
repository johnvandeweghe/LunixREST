<?php
namespace LunixREST\AccessControl;

use LunixREST\Configuration\INIConfiguration;

/**
 * Class AllAccessINIAccessControl
 * @package LunixREST\AccessControl
 */
class AllAccessINIAccessControl implements AccessControl {
    /**
     * @var string
     */
    protected $filename;

    /**
     * @param string $filename
     */
    public function __construct($filename = 'config/api_keys.ini'){
        $this->filename = $filename;
    }

    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @param $instance
     * @return bool
     * @throws \LunixREST\Exceptions\INIParseException
     */
    public function validate($apiKey, $endPoint, $method, $instance){
        $keyConfig = new INIConfiguration($this->filename);
        return in_array($apiKey, $keyConfig->get('keys'));
    }
}