<?php
namespace LunixREST\Server\ResponseFactory\Exceptions;

use LunixREST\Server\Exceptions\UnableToHandleRequestException;

/**
 * An exception that is thrown when a Response type can't satisfy the request's acceptable types list.
 * Class NotAcceptableResponseTypeException
 * @package LunixREST\Server\ResponseFactory\Exceptions
 */
class UnableToCreateAPIResponseException extends UnableToHandleRequestException
{

}
