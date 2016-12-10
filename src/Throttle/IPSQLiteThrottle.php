<?php
namespace LunixREST\Throttle;

use LunixREST\Request\Request;

class IPSQLiteThrottle extends SQLiteThrottle {

    /**
     * Throttle using SQLite based on the request's IP address
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function throttle(Request $request)
    {
        $this->genericThrottle(str_replace('.', '_', $request->getIp()));
    }
}