<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
 * Class MultiAccessControl
 * @package LunixREST\AccessControl
 */
class MultiAndAccessControl extends MultiAccessControl {
    /**
     * @param \LunixREST\Request\Request $request
     * @return bool true if all of the $accessControls' validate access methods returned true for the given request
     */
    public function validateAccess(Request $request){
        foreach($this->accessControls as $accessControl){
            if(!$accessControl->validateAccess($request)){
                return false;
            }
        }
        return true;
    }

    /**
     * @param $apiKey
     * @return bool true if all of the $accessControls' validate key methods returned true for the given request
     */
    public function validateKey($apiKey){
        foreach($this->accessControls as $accessControl){
            if(!$accessControl->validateKey($apiKey)){
                return false;
            }
        }
        return true;
    }
}