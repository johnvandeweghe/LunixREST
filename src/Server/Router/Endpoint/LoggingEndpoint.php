<?php
namespace LunixREST\Server\Router\Endpoint;

use Psr\Log\LoggerAwareTrait;

/**
 * An Endpoint implementation that has a PSR Logger. Used with a LoggingEndpointFactory.
 * Class LoggingEndpoint
 * @package LunixREST\Server\Router\Endpoint
 * @deprecated in favor of just directly using the LoggerAwareTrait.
 */
abstract class LoggingEndpoint implements Endpoint
{
    use LoggerAwareTrait;
}
