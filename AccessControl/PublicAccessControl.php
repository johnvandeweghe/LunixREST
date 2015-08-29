<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
 * Class PublicAccessControl
 * @package LunixREST\AccessControl
 */
class PublicAccessControl implements AccessControl {
    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @param string $publicKey
     */
    public function __construct($publicKey = 'public'){
        $this->publicKey = $publicKey;
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
     * @return bool true if key is the key specified in the constructor
     */
    public function validateKey($apiKey){
        return $apiKey === $this->publicKey;
    }
}