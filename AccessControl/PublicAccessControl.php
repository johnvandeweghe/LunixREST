<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
 * Class PublicAccessControl
 * @package LunixREST\AccessControl
 */
class PublicAccessControl implements AccessControl {
    protected $publicKey;

    /**
     * @param string $publicKey
     */
    public function __construct($publicKey = 'public'){
        $this->publicKey = $publicKey;
    }

    /**
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public function validateAccess(Request $request){
        return $this->validateKey($request->getApiKey());
    }

    public function validateKey($apiKey){
        return $apiKey === $this->publicKey;
    }
}