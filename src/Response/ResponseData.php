<?php
namespace LunixREST\Response;

/**
 * Class Response
 * @package LunixREST\Response
 */
interface ResponseData
{
    /**
     * @return array
     */
    public function getAsAssociativeArray(): array;

}
