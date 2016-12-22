<?php
namespace LunixREST\AccessControl;

use LunixREST\APIRequest\APIRequest;

/**
 * Take all of our Multiple access controls, and verify each one returns true (logical AND)
 * Class MultiAccessControl
 * @package LunixREST\AccessControl
 */
class MultiAndAccessControl extends MultiAccessControl
{
    /**
     * @param \LunixREST\APIRequest\APIRequest $request
     * @return bool true if all of the $accessControls' validate access methods returned true for the given request
     */
    public function validateAccess(APIRequest $request)
    {
        foreach ($this->accessControls as $accessControl) {
            if (!$accessControl->validateAccess($request)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $apiKey
     * @return bool true if all of the $accessControls' validate key methods returned true for the given request
     */
    public function validateKey($apiKey)
    {
        foreach ($this->accessControls as $accessControl) {
            if (!$accessControl->validateKey($apiKey)) {
                return false;
            }
        }
        return true;
    }
}
