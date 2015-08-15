<?php
namespace LunixREST\Throttle;

use LunixREST\Request\Request;

class APIKeySQLiteThrottle extends SQLiteThrottle {

    /**
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function throttle(Request $request)
    {
        $this->genericThrottle($request->getApiKey());
    }
}