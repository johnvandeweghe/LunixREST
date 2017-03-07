<?php
namespace LunixREST\AccessControl;

use LunixREST\APIRequest\APIRequest;

/**
 * Access control for a public API, ignores all parameters and allows full access.
 * Class PublicAccessControl
 * @package LunixREST\AccessControl
 */
class PublicAccessControl implements AccessControl
{
    /**
     * @param \LunixREST\APIRequest\APIRequest $request
     * @return bool
     */
    public function validateAccess(APIRequest $request)
    {
        return true;
    }

    /**
     * @param $apiKey
     * @return bool
     */
    public function validateKey($apiKey)
    {
        return true;
    }
}
