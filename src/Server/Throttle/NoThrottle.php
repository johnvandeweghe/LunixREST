<?php
namespace LunixREST\Server\Throttle;

use LunixREST\Server\APIRequest\APIRequest;

/**
 * A throttle that never throttles.
 * Class NoThrottle
 * @package LunixREST\Server\Throttle
 */
class NoThrottle implements Throttle
{
    /**
     * Never throttle
     * @param \LunixREST\Server\APIRequest\APIRequest $request
     * @return bool
     */
    public function shouldThrottle(APIRequest $request): bool
    {
        return false;
    }

    /**
     * Log that a request took place
     * @param \LunixREST\Server\APIRequest\APIRequest $request
     */
    public function logRequest(APIRequest $request): void
    {
        //Do nothing
    }
}
