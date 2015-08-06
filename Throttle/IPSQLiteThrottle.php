<?php
namespace LunixREST\Throttle;

class IPSQLiteThrottle extends SQLiteThrottle {

    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @param $ip
     * @return bool
     */
    public function throttle($apiKey, $endPoint, $method, $ip)
    {
        $this->genericThrottle(str_replace('.', '_', $ip));
    }
}