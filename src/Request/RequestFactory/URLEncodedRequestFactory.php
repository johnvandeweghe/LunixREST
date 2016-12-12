<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\BodyParser\URLEncodedBodyParser;
use LunixREST\Request\URLParser\URLParser;

class URLEncodedRequestFactory extends GenericRequestFactory {
    public function __construct(URLParser $URLParser) {
        parent::__construct($URLParser, new URLEncodedBodyParser());
    }
}
