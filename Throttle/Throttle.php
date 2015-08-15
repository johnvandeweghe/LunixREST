<?php
namespace LunixREST\Throttle;
use LunixREST\Request\Request;

/**
 * Interface Throttle
 * @package LunixREST\Throttle
 */
interface Throttle {
    /**
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function throttle(Request $request);
}