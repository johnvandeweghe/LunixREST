<?php
namespace LunixREST\Endpoint;

use Psr\Log\LoggerAwareTrait;

abstract class LoggingEndpoint implements Endpoint
{
    use LoggerAwareTrait;
}
