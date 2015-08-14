<?php
namespace LunixREST\Throttle;

class NoThrottle implements Throttle {

    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @param $ip
     * @return bool
     */
    public function throttle($apiKey, $endPoint, $method, $ip)
    {
        return false;
    }
}