<?php
namespace LunixREST\APIRequest\RequestFactory;

use LunixREST\APIRequest\HeaderParser\DefaultHeaderParser;
use LunixREST\APIRequest\URLParser\URLParser;

/**
 * A default RequestFactory. Takes in a url Parser, and uses a DefaultBodyParserFactory and a DefaultHeaderParser
 * Class BasicRequestFactory
 * @package LunixREST\Request\RequestFactory
 */
class DefaultRequestFactory extends GenericRequestFactory
{
    public function __construct(URLParser $URLParser)
    {
        parent::__construct($URLParser, new DefaultHeaderParser());
    }
}
