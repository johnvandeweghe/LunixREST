<?php
namespace LunixREST\AccessControl;

/**
 * Class PublicAccessControl
 * @package LunixREST\AccessControl
 */
class PublicAccessControl implements AccessControl {
    protected $publicKey;

    /**
     *
     */
    public function __construct($publicKey = 'public'){
        $this->publicKey = $publicKey;
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
        return $apiKey === $this->publicKey;
    }
}