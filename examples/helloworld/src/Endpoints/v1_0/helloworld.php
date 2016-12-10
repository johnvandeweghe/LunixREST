<?php
namespace HelloWorld\Endpoints\v1_0;

use LunixREST\Endpoints\Endpoint;

class helloworld extends Endpoint {
    public function getAll(){
		return ["helloworld" => "hello world"];
	}
}