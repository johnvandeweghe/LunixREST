<?php
namespace LunixREST\Request\RequestFactory;

use LunixREST\Request\MIMEFileProvider;
use LunixREST\Request\URLParser\BasicURLParser;

/**
 * A super basic RequestFactory. Uses a BasicURLParser, instantiated with a MIMEFileProvider
 * Class BasicRequestFactory
 * @package LunixREST\Request\RequestFactory
 */
class BasicRequestFactory extends DefaultRequestFactory {
    public function __construct() {
        parent::__construct(new BasicURLParser(new MIMEFileProvider()));
    }
}
