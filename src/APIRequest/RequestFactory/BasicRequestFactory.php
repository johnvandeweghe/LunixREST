<?php
namespace LunixREST\APIRequest\RequestFactory;

use LunixREST\APIRequest\MIMEFileProvider;
use LunixREST\APIRequest\URLParser\BasicURLParser;

/**
 * A super basic RequestFactory. Uses a BasicURLParser, instantiated with a MIMEFileProvider
 * Class BasicRequestFactory
 * @package LunixREST\Request\RequestFactory
 */
class BasicRequestFactory extends DefaultRequestFactory
{
    public function __construct()
    {
        parent::__construct(new BasicURLParser(new MIMEFileProvider()));
    }
}
