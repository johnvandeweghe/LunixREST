<?php
namespace LunixREST\Throttle;
use LunixREST\Request\Request;

/**
 * Interface Throttle
 * @package LunixREST\Throttle
 */
interface Throttle {
    /**
     * Returns true if the given request should be throttled in our implementation
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function shouldThrottle(Request $request): bool;

    /**
     * Log that a request took place
     * @param \LunixREST\Request\Request $request
     */
    public function logRequest(Request $request);
}