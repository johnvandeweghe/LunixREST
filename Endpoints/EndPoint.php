<?php
namespace LunixREST\EndPoints;

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
    public abstract function get($instance, $data);

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public abstract function post($instance, $data);

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public abstract function put($instance, $data);

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public abstract function options($instance, $data);

    /**
     * @param $instance
     * @param $data
     * @return array
     */
    public abstract function delete($instance, $data);
}
