<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
 * Interface AccessControl
 * @package LunixREST\AccessControl
 */
interface AccessControl {
    /**
     * @param $request
     * @return bool
     */
    public function validateAccess(Request $request);

    public function validateKey($apiKey);
}