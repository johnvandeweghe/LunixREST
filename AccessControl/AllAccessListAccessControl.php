<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
 * Class AllAccessListAccessControl
 * @package LunixREST\AccessControl
 */
class AllAccessListAccessControl implements AccessControl {
    /**
     * @var array
     */
    protected $keys;

    /**
     * @param array $keys
     */
    public function __construct(Array $keys){
        $this->keys = $keys;
    }

    /**
     * @param \LunixREST\Request\Request $request
     * @return bool true if key is valid
     */
    public function validateAccess(Request $request){
        return $this->validateKey($request->getApiKey());
    }

    /**
     * @param $apiKey
     * @return bool true if key is in the array passed to this object in it's construction
     */
    public function validateKey($apiKey){
        return in_array($apiKey, $this->keys);
    }
}