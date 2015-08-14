<?php
namespace Sample\Endpoints\v1_0;

class helloworld extends \LunixREST\Endpoints\Endpoint {
    public function getAll(){
		return ["helloworld" => "hello world"];
	}
}