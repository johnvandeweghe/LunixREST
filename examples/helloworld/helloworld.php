<?php
namespace Sample\EndPoints;

class helloworld extends \LunixREST\EndPoints\EndPoint {
    public function getAll($data){
		return ["helloworld" => "hello world"];
	}
}