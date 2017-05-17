<?php
namespace LunixREST\Server\AccessControl;

use LunixREST\Server\APIRequest\APIRequest;

/**
 * Gives full access to any keys found in the key repository. Useful for simple APIs that don't need different types of keys.
 * Class AllAccessKeyRepositoryAccessControl
 * @package LunixREST\Server\AccessControl
 */
class AllAccessKeyRepositoryAccessControl extends KeyRepositoryAccessControl
{

    /**
     * Validates if a given request should be able to access what it's trying to
     * @param APIRequest $request
     * @return bool
     */
    public function validateAccess(APIRequest $request): bool
    {
        return $this->validateKey($request->getApiKey());
    }
}
