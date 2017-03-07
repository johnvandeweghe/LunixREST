<?php
namespace LunixREST\Endpoint;

use Psr\Log\LoggerAwareTrait;

/**
 * An Endpoint implementation that has a PSR Logger. Used with a LoggingEndpointFactory.
 * It is recommended to always use this instead of the base Endpoint, as it's super easy to use a NullLogger if your API doesn't need logging.
 * Class LoggingEndpoint
 * @package LunixREST\Endpoint
 */
abstract class LoggingEndpoint implements Endpoint
{
    use LoggerAwareTrait;
}
