<?php
namespace LunixREST\APIRequest;

/**
 * A MIMEProvider that works off of a mime.types file often found in Linux distros. Defaults to the common path.
 * Warning: Probably won't work under Windows, unless you can supply it a mime.types file
 * Note that much of this behaviour derives from: http://stackoverflow.com/a/1147952
 * Class MIMEFileProvider
 * @package LunixREST\Request
 */
class MIMEFileProvider implements MIMEProvider
{
    protected $file;

    protected $cache;

    public function __construct($filePath = '/etc/mime.types')
    {
        $this->file = fopen($filePath, 'r');
    }

    public function getAll(): array
    {
        if ($this->cache) {
            return $this->cache;
        }

        # Returns the system MIME type mapping of extensions to MIME types, as defined in /etc/mime.types.
        $out = array();
        while (($line = fgets($this->file)) !== false) {
            $line = trim(preg_replace('/#.*/', '', $line));
            if (!$line) {
                continue;
            }
            $parts = preg_split('/\s+/', $line);
            if (count($parts) == 1) {
                continue;
            }
            $type = array_shift($parts);
            foreach ($parts as $part) {
                $out[$part] = $type;
            }
        }

        $this->cache = $out;

        return $out;
    }

    public function getByFileExtension($extension): string
    {
        # Returns the system MIME type (as defined in /etc/mime.types) for the filename specified.
        #
        # $file - the filename to examine
        $types = $this->getAll();

        return $types[strtolower($extension)] ?? null;
    }
}
