<?php
namespace LunixREST\EndPoints;

use LunixREST\Exceptions\UnknownEndPointException;
use LunixREST\Request\Request;

/**
 * Class EndPoint
 * @package LunixREST\EndPoints
 */
abstract class EndPoint {
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request){
        $this->request = $request;
    }

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public function get($instance, $data){
        $this->unsupportedMethod();
    }

    /**
     * @param $data
     * @return array
     */
    public function getAll($data){
        $this->unsupportedMethod();
    }

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public function post($instance, $data){
        $this->unsupportedMethod();
    }

    /**
     * @param $data
     * @return array
     */
    public function postAll($data){
        $this->unsupportedMethod();
    }

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public function put($instance, $data){
        $this->unsupportedMethod();
    }

    /**
     * @param $data
     * @return array
     */
    public function putAll($data){
        $this->unsupportedMethod();
    }

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public function options($instance, $data){
        $this->unsupportedMethod();
    }


    /**
     * @param $data
     * @return array
     */
    public function optionsAll( $data){
        $this->unsupportedMethod();
    }

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public function delete($instance, $data){
        $this->unsupportedMethod();
    }

    /**
     * @param $data
     * @return array
     */
    public function deleteAll($data){
        $this->unsupportedMethod();
    }

    private function unsupportedMethod(){
        throw new UnknownEndPointException('Method not supported');
    }
}
