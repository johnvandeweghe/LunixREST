<?php
namespace LunixREST\Response;

/**
 * Class Response
 * @package LunixREST\Response
 */
interface Response {
    /**
     * @return ResponseData
     */
    public function getResponseData(): ResponseData;

    /**
     * @return string
     */
    public function getAsString(): string;

}
