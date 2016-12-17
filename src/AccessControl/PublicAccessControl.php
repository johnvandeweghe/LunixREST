<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
 * Access control for a public API, ignores all parameters and allows full access
 * Class PublicAccessControl
 * @package LunixREST\AccessControl
 */
class PublicAccessControl implements AccessControl {
    /**
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function validateAccess(Request $request){
        return true;
    }

    /**
     * @param $apiKey
     * @return bool
     */
    public function validateKey($apiKey){
        return true;
    }
}
