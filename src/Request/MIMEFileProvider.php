<?php
namespace LunixREST\Request;

//TODO: Unit test?
class MIMEFileProvider implements MIMEProvider {
    protected $file;

    protected $cache;

    public function __construct($filePath = '/etc/mime.types') {
        $this->file = fopen($filePath, 'r');
    }

    //Borrowed from http://stackoverflow.com/a/1147952
    public function getAll(): array {
        if($this->cache){
            return $this->cache;
        }

        # Returns the system MIME type mapping of extensions to MIME types, as defined in /etc/mime.types.
        $out = array();
        while(($line = fgets($this->file)) !== false) {
            $line = trim(preg_replace('/#.*/', '', $line));
            if(!$line) {
                continue;
            }
            $parts = preg_split('/\s+/', $line);
            if(count($parts) == 1) {
                continue;
            }
            $type = array_shift($parts);
            foreach($parts as $part) {
                $out[$part] = $type;
            }
        }

        $this->cache = $out;

        return $out;
    }

    //Borrowed from http://stackoverflow.com/a/1147952
    public function getByFileExtension($extension): string {
        # Returns the system MIME type (as defined in /etc/mime.types) for the filename specified.
        #
        # $file - the filename to examine
        $types = $this->getAll();

        return $types[strtolower($extension)] ?? null;
    }
}
