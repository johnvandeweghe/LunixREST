<?php
namespace LunixREST\APIRequest\URLParser;

use LunixREST\APIRequest\URLParser\Exceptions\UnableToProvideMIMEException;

/**
 * Providers a MIME type for a given file extension
 * Interface MIMEProvider
 * @package LunixREST\APIRequest\URLParser
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
