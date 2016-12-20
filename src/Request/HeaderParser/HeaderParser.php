<?php
namespace LunixREST\Request\HeaderParser;

interface HeaderParser
{
    public function parse(array $headers): ParsedHeaders;
}
