<?php
namespace LunixREST\Server\AccessControl;

use LunixREST\Server\APIRequest\APIRequest;

/**
 * Access control for a public API, ignores all parameters and allows full access.
 * Class PublicAccessControl
 * @package LunixREST\Server\AccessControl
 */
class PublicAccessControl implements AccessControl
{
    /**
     * @param \LunixREST\Server\APIRequest\APIRequest $request
     * @return bool
     */
    public function validateAccess(APIRequest $request): bool
    {
        return true;
    }

    /**
     * @param $apiKey
     * @return bool
     */
    public function validateKey($apiKey): bool
    {
        return true;
    }
}
