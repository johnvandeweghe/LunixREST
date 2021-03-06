<?php
namespace LunixREST\Server\Router\Exceptions;

use LunixREST\Server\Exceptions\UnableToHandleRequestException;

/**
 * An exception that is thrown when a Router can't find the parsed method on an Endpoint.
 * Class MethodNotFoundException
 * @package LunixREST\Server\Router\Exceptions
 */
class MethodNotFoundException extends UnableToRouteRequestException
{

}
