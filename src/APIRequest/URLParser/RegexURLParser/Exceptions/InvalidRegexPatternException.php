<?php
namespace LunixREST\APIRequest\URLParser\RegexURLParser\Exceptions;

/**
 * Thrown when a RegexURLParser is constructed with an invalid pattern. The code will be the preg_last_error constant.
 * Class InvalidRequestURLException
 * @package LunixREST\APIRequest\URLParser\RegexURLParser\Exceptions
 */
class InvalidRegexPatternException extends \Exception
{

}
