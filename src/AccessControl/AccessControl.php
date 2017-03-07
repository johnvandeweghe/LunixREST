<?php
namespace LunixREST\AccessControl;

use LunixREST\APIRequest\APIRequest;

/**
 * This interface is used to define AccessControllers. Used to validate a request's access, as well as validate API keys.
 * Interface AccessControl
 * @package LunixREST\AccessControl
 */
interface AccessControl
{
    /**
     * Validates if a given request should be able to access what it's trying to
     * @param $request
     * @return bool
     */
    public function validateAccess(APIRequest $request);

    /**
     * Validates if a key is proper in our implementation
     * @param $apiKey
     * @return mixed
     */
    public function validateKey($apiKey);
}
