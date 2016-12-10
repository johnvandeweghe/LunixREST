<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
 * Class MultiAccessControl
 * @package LunixREST\AccessControl
 */
abstract class MultiAccessControl implements AccessControl {
    /**
     * @var AccessControl[]
     */
    protected $accessControls;

    /**
     * @param AccessControl[] $accessControls array of access controls to use based on implmentation
     */
    public function __construct(array $accessControls){
        $this->accessControls = $accessControls;
    }
}