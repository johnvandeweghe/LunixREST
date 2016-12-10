<?php
namespace HelloWorld\Endpoints\v1_0;

use LunixREST\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\Endpoint\DefaultEndpoint;
use LunixREST\Request\Request;
use LunixREST\Response\ResponseData;

class helloworld extends DefaultEndpoint {

    /**
     * @param Request $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function getAll(Request $request): ResponseData{
        $helloWorld = new \HelloWorld\Models\HelloWorld();

        return $helloWorld;
	}
}
