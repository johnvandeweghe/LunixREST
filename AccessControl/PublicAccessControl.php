<?php
namespace LunixREST\AccessControl;

/**
 * Class PublicAccessControl
 * @package LunixREST\AccessControl
 */
class PublicAccessControl implements AccessControl {
    /**
     *
     */
    public function __construct(){

    }

    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @param $instance
     * @return bool
     */
    public function validate($apiKey, $endPoint, $method, $instance){
        return true;
    }
}