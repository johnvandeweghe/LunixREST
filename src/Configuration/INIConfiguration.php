<?php
namespace LunixREST\Configuration;

use LunixREST\Configuration\Exceptions\INIParseException;

/**
 * Configuration that reads in an ini file
 * Class INIConfiguration
 * @package LunixREST\Configuration
 */
class INIConfiguration implements Configuration
{
    /**
     * @var
     */
    protected $config;

    /**
     * @param string $filename
     * @throws INIParseException
     */
    public function __construct($filename)
    {
        $this->config = parse_ini_file($filename, true);

        if ($this->config === false) {
            throw new INIParseException('Could not parse: ' . $filename, true);
        }
    }

    /**
     * @param $key
     * @param $namespace
     * @return mixed
     */
    public function get($key, $namespace)
    {
        return $this->config[$namespace][$key] ?? null;
    }

    /**
     * @param $key
     * @param $namespace
     * @return bool
     */
    public function has($key, $namespace): bool
    {
        return isset($this->config[$namespace]) && isset($this->config[$namespace][$key]);
    }
}
