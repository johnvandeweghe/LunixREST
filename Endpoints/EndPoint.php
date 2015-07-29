<?php
namespace LunixREST\EndPoints;

use LunixREST\Request\Request;

abstract class EndPoint {
    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public abstract function get($instance);
    public abstract function post($instance);
    public abstract function put($instance);
    public abstract function options($instance);
    public abstract function delete($instance);
}