<?php
namespace LunixREST\RequestFactory;

use LunixREST\RequestFactory\HeaderParser\DefaultHeaderParser;
use LunixREST\RequestFactory\URLParser\URLParser;

/**
 * A default RequestFactory. Takes in a url Parser, and uses a DefaultBodyParserFactory and a DefaultHeaderParser.
 * Class BasicRequestFactory
 * @package LunixREST\RequestFactory
 */
class DefaultRequestFactory extends GenericRequestFactory
{
    public function __construct(URLParser $URLParser)
    {
        parent::__construct($URLParser, new DefaultHeaderParser());
    }
}
