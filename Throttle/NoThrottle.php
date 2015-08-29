<?php
namespace LunixREST\Throttle;

use LunixREST\Request\Request;

class NoThrottle implements Throttle {

    /**
     * Never throttle
     * @param \LunixREST\Request\Request $request
     * @return false
     */
    public function throttle(Request $request)
    {
        return false;
    }
}