<?php
namespace LunixREST\AccessControl;

/**
 * Class AllAccessListAccessControl
 * @package LunixREST\AccessControl
 */
class AllAccessListAccessControl implements AccessControl {
    /**
     * @var array
     */
    protected $keys;

    /**
     * @param array $keys
     */
    public function __construct(Array $keys){
        $this->keys = $keys;
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
        return in_array($apiKey, $this->keys);
    }
}