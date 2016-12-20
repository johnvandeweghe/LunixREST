<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\BodyParser\BodyParserFactory\DefaultBodyParserFactory;
use LunixREST\Request\HeaderParser\DefaultHeaderParser;
use LunixREST\Request\URLParser\URLParser;

/**
 * A default RequestFactory. Takes in a url Parser, and uses a DefaultBodyParserFactory and a DefaultHeaderParser
 * Class BasicRequestFactory
 * @package LunixREST\Request\RequestFactory
 */
class DefaultRequestFactory extends GenericRequestFactory
{
    public function __construct(URLParser $URLParser)
    {
        parent::__construct($URLParser, new DefaultBodyParserFactory(), new DefaultHeaderParser());
    }
}
