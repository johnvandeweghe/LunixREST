<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\MIMEFileProvider;
use LunixREST\Request\URLParser\BasicURLParser;

class BasicURLEncodedRequestFactory extends URLEncodedRequestFactory {
    public function __construct() {
        parent::__construct(new BasicURLParser(), new MIMEFileProvider());
    }
}
