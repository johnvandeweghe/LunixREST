<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\BodyParser\BasicBodyParserFactory;
use LunixREST\Request\HeaderParser\BasicHeaderParser;
use LunixREST\Request\MIMEFileProvider;
use LunixREST\Request\URLParser\BasicURLParser;

/**
 * A super basic RequestFactory. Uses a BasicURLParser, instantiated with a MIMEFileProvider, a BasicBodyParserFactory and a BasicHeaderParser
 * Class BasicRequestFactory
 * @package LunixREST\Request\RequestFactory
 */
//TODO: Consider splitting basicURLParser out to being passed in and renaming class to Default*
class BasicRequestFactory extends GenericRequestFactory {
    public function __construct() {
        parent::__construct(new BasicURLParser(new MIMEFileProvider()), new BasicBodyParserFactory(), new BasicHeaderParser());
    }
}
