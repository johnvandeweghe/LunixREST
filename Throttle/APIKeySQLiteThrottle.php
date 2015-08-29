<?php
namespace LunixREST\Throttle;

use LunixREST\Request\Request;

class APIKeySQLiteThrottle extends SQLiteThrottle {

    /**
     * Throttle using SQLite based on the request's API Key
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function throttle(Request $request)
    {
        $this->genericThrottle($request->getApiKey());
    }
}