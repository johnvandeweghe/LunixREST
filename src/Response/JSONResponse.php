<?php
namespace LunixREST\Response;

/**
 * Class JSONResponse
 * @package LunixREST\Response
 */
class JSONResponse implements Response {
    /**
     * @var ResponseData
     */
    public $data;

    public function __construct(ResponseData $data) {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getAsString(): string {
        return json_encode($this->data->getAsAssociativeArray());
    }

    public function getMIMEType(): string {
        return 'application/json';
    }

    /**
     * @return ResponseData
     */
    public function getResponseData(): ResponseData {
        return $this->data;
    }
}
