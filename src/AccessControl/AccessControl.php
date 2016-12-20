<?php
namespace LunixREST\AccessControl;

use LunixREST\Request\Request;

/**
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
    public function validateAccess(Request $request);

    /**
     * Validates if a key is proper in our implementation
     * @param $apiKey
     * @return mixed
     */
    public function validateKey($apiKey);
}
