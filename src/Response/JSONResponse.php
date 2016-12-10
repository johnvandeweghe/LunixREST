<?php
namespace LunixREST\Response;

/**
 * Class JSONResponse
 * @package LunixREST\Response
 */
class JSONResponse extends Response {
    /**
     * @return string
     */
    public function output(){
        return json_encode($this->data);
    }
}
