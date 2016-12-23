<?php
namespace HelloWorld\Models;

use LunixREST\APIResponse\ResponseData;

class HelloWorld implements ResponseData
{

    protected $helloWorld = "HelloWorld";

    /**
     * @return array
     */
    public function getAsAssociativeArray(): array
    {
        return [
            "helloworld" => $this->helloWorld
        ];
    }
}
