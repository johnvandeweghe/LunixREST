<?php
namespace LunixREST\Response;

use LunixREST\Configuration\OutputINIConfiguration;

abstract class Response {
    protected $data;
    public function __construct(array $data){
        $this->data = $data;
    }
    public abstract function output();

    public function validate($method, $endPoint, $version){
        $config = new OutputINIConfiguration(strtolower($method) . $endPoint);

        $format = $config[$version];

        if(count($this->data) != count($format)){
            return false;
        }

        return !array_diff_key($format, $this->data);
    }
}
