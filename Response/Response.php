<?php
namespace LunixREST\Response;

use LunixREST\Configuration\Configuration;
use LunixREST\Configuration\OutputINIConfiguration;

/**
 * Class Response
 * @package LunixREST\Response
 */
abstract class Response {
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data){
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public abstract function output();

    /**
     * @param Configuration $outputConfig
     * @param $method
     * @param $endPoint
     * @param $version
     * @return bool
     */
    public function validate(Configuration $outputConfig, $method, $endPoint, $version){
        $format = $outputConfig->get(strtolower($method) . '_' . $endPoint . '_' . str_replace(".", "_", $version));

        if(count($this->data) != count($format)){
            return false;
        }

        return (bool)!array_diff_key(array_flip($format), $this->data);
    }
}
