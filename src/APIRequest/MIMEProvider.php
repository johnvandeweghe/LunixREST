<?php
namespace LunixREST\APIRequest;

/**
 * An interface for converting file extensions to a mime type.
 * Interface MIMEProvider
 * @package LunixREST\Request
 */
interface MIMEProvider
{
    public function getAll(): array;

    public function getByFileExtension($extension): string;
}
