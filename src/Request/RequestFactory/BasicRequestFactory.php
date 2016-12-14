<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\BodyParser\BasicBodyParserFactory;
use LunixREST\Request\HeaderParser\BasicHeaderParser;
use LunixREST\Request\MIMEFileProvider;
use LunixREST\Request\URLParser\BasicURLParser;

class BasicRequestFactory extends GenericRequestFactory {
    public function __construct() {
        parent::__construct(new BasicURLParser(new MIMEFileProvider()), new BasicBodyParserFactory(), new BasicHeaderParser());
    }
}
