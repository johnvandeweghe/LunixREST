<?php
namespace LunixREST\APIResponse;

class APIResponseData {
    protected $data;

    /**
     * APIResponseData constructor.
     * @param null|object|array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }
}
