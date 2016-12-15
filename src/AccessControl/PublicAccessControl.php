<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
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
