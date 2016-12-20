<?php
namespace LunixREST\Throttle;

use LunixREST\Request\Request;

class NoThrottle implements Throttle
{
    /**
     * Never throttle
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function shouldThrottle(Request $request): bool
    {
        return false;
    }

    /**
     * Log that a request took place
     * @param \LunixREST\Request\Request $request
     */
    public function logRequest(Request $request)
    {
        //Do nothing
    }
}
