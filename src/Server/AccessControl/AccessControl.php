<?php
namespace LunixREST\Server\AccessControl;

use LunixREST\Server\APIRequest\APIRequest;

/**
 * This interface is used to define AccessControllers. Used to validate a request's access, as well as validate API keys.
 * Interface AccessControl
 * @package LunixREST\Server\AccessControl
 */
interface AccessControl
{
    /**
     * Validates if a given request should be able to access what it's trying to
     * @param APIRequest $request
     * @return bool
     */
    public function validateAccess(APIRequest $request): bool;

    /**
     * Validates if a key is proper in our implementation
     * @param $apiKey
     * @return bool
     */
    public function validateKey($apiKey): bool;
}
