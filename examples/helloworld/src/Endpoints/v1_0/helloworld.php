<?php
namespace HelloWorld\Endpoints\v1_0;

use LunixREST\Endpoint\DefaultEndpoint;
use LunixREST\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\APIRequest\APIRequest;
use LunixREST\APIResponse\ResponseData;

class helloworld extends DefaultEndpoint
{

    /**
     * @param APIRequest $request
     * @return ResponseData
     * @throws UnsupportedMethodException
     */
    public function getAll(APIRequest $request): ResponseData
    {
        $helloWorld = new \HelloWorld\Models\HelloWorld();

        return $helloWorld;
    }
}
