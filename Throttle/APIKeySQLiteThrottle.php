<?php
namespace LunixREST\Throttle;

class APIKeySQLiteThrottle extends SQLiteThrottle {

    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @param $ip
     * @return bool
     */
    public function throttle($apiKey, $endPoint, $method, $ip)
    {
        $this->genericThrottle($apiKey);
    }
}