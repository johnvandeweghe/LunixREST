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
     * @return bool
     */
    public function validateAccess(Request $request){
        return $this->validateKey($request->getApiKey());
    }

    public function validateKey($apiKey){
        return in_array($apiKey, $this->keys);
    }
}