<?php
namespace LunixREST\Response;

class JSONResponse extends Response {
    public function output(){
        return json_encode($this->data);
    }
}