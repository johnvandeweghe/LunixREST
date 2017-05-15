<?php
namespace LunixREST\RequestFactory\URLParser;

use LunixREST\RequestFactory\URLParser\Exceptions\UnableToProvideMIMEException;

/**
 * Providers a MIME type for a given file extension
 * Interface MIMEProvider
 * @package LunixREST\RequestFactory\URLParser
 */
interface MIMEProvider
{
    /**
     * @param string $fileExtension
     * @return string
     * @throws UnableToProvideMIMEException
     */
    public function provideMIME(string $fileExtension): string;
}
