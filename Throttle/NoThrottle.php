<?php
namespace LunixREST\Throttle;

class NoThrottle implements Throttle {

    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @return bool
     */
    public function throttle($apiKey, $endPoint, $method)
    {
        return false;
    }
}