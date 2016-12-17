<?php
namespace LunixREST\AccessControl;
use LunixREST\Request\Request;

/**
 * Abstractly allow multiple access controls. Checking of them depends on implementation
 * Class MultiAccessControl
 * @package LunixREST\AccessControl
 */
abstract class MultiAccessControl implements AccessControl {
    /**
     * @var AccessControl[]
     */
    protected $accessControls;

    /**
     * @param AccessControl[] $accessControls array of access controls
     */
    public function __construct(array $accessControls){
        $this->accessControls = $accessControls;
    }
}
