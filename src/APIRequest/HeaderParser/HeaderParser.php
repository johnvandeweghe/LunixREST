<?php
namespace LunixREST\APIRequest\HeaderParser;

interface HeaderParser
{
    public function parse(array $headers): ParsedHeaders;
}
