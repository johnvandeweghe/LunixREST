<?php
namespace LunixREST\Response;

/**
 * Class Response
 * @package LunixREST\Response
 */
interface Response
{
    /**
     * @return ResponseData
     */
    public function getResponseData(): ResponseData;

    public function getMIMEType(): string;

    /**
     * @return string
     */
    public function getAsString(): string;

}
