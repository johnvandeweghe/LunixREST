<?php
namespace LunixREST\Throttle;

use LunixREST\APIRequest\APIRequest;

/**
 * An interface for deciding whether or not to throttle a request.
 * Interface Throttle
 * @package LunixREST\Throttle
 */
interface Throttle
{
    /**
     * Returns true if the given request should be throttled in our implementation
     * @param \LunixREST\APIRequest\APIRequest $request
     * @return bool
     */
    public function shouldThrottle(APIRequest $request): bool;

    /**
     * Log that a request took place
     * @param \LunixREST\APIRequest\APIRequest $request
     */
    public function logRequest(APIRequest $request);
}
