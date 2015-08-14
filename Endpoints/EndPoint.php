<?php
namespace LunixREST\Endpoints;

use LunixREST\Exceptions\UnknownEndpointException;
use LunixREST\Request\Request;

/**
 * Class Endpoint
 * @package LunixREST\Endpoints
 */
abstract class Endpoint {
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
     * @return array
     */
    public function get(){
        $this->unsupportedMethod();
    }

    /**
     * @return array
     */
    public function getAll(){
        $this->unsupportedMethod();
    }

    /**
     * @return array
     */
    public function post(){
        $this->unsupportedMethod();
    }

    /**
     * @return array
     */
    public function postAll(){
        $this->unsupportedMethod();
    }

    /**
     * @return array
     */
    public function put(){
        $this->unsupportedMethod();
    }

    /**
     * @return array
     */
    public function putAll(){
        $this->unsupportedMethod();
    }

    /**
     * @return array
     */
    public function options(){
        $this->unsupportedMethod();
    }


    /**
     * @return array
     */
    public function optionsAll(){
        $this->unsupportedMethod();
    }

    /**
     * @return array
     */
    public function delete(){
        $this->unsupportedMethod();
    }

    /**
     * @return array
     */
    public function deleteAll(){
        $this->unsupportedMethod();
    }

    private function unsupportedMethod(){
        throw new UnknownEndpointException('Method not supported');
    }
}
