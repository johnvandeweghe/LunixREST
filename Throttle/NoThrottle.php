<?php
namespace LunixREST\Throttle;

use LunixREST\Request\Request;

class NoThrottle implements Throttle {

    /**
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function throttle(Request $request)
    {
        return false;
    }
}