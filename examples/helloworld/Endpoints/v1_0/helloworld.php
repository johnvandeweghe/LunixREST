<?php
namespace Sample\Endpoints\v1_0;

use LunixREST\Endpoints\Endpoint;

class helloworld extends Endpoint {
    public function getAll(){
		return ["helloworld" => "hello world"];
	}
}