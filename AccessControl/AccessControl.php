<?php
namespace LunixREST\AccessControl;

/**
 * Interface AccessControl
 * @package LunixREST\AccessControl
 */
interface AccessControl {
    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @param $instance
     * @return bool
     */
    public function validate($apiKey, $endPoint, $method, $instance);
}