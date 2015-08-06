<?php
namespace LunixREST\Throttle;

/**
 * Interface Throttle
 * @package LunixREST\Throttle
 */
interface Throttle {
    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @return bool
     */
    public function throttle($apiKey, $endPoint, $method);
}