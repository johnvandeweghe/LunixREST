<?php
namespace Sample\EndPoints;

class helloworld extends \LunixREST\EndPoints\EndPoint {
    public function get($instance, $data){
		return ["helloworld" => "hello world"];
	}
    public function post($instance, $data){
	}
    public function put($instance, $data){
	}
    public function options($instance, $data){
	}
    public function delete($instance, $data){
	}
}