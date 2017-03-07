<?php
namespace LunixREST\Endpoint\Exceptions;

/**
 * An exception that is thrown when an EndpointFactory can't return an Endpoint (usually because the requested one is unknown to it).
 * Class UnknownEndpointException
 * @package LunixREST\Endpoint\Exceptions
 */
class UnknownEndpointException extends \Exception
{

}
