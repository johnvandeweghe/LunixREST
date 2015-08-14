<?php
namespace LunixREST\Response;

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

}
