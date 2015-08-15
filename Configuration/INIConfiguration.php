<?php
namespace LunixREST\Configuration;

use LunixREST\Exceptions\INIParseException;

/**
 * Class INIConfiguration
 * @package LunixREST\Configuration
 */
class INIConfiguration implements Configuration {
	/**
	 * @var null
	 */
	protected $nameSpace;
	/**
	 * @var
	 */
	protected $filename;

	/**
	 * @param string $filename
	 * @param string $nameSpace
	 */
	public function __construct($filename, $nameSpace = null){
		$this->filename = $filename;
		$this->nameSpace = $nameSpace;
	}

	/**
	 * @param $key
	 * @return mixed
	 * @throws INIParseException
	 */
	public function get($key){
		$config = parse_ini_file($this->filename);

		if($config === false){
			throw new INIParseException('Could not parse: ' . $this->filename, true);
		}

		if($this->nameSpace && isset($config[$this->nameSpace]) && isset($config[$this->nameSpace][$key])) {
			return $config[$this->nameSpace][$key];
		} elseif(isset($config[$key])) {
			return $config[$key];
		} else {
			return null;
		}
	}

	/**
	 * @param $key
	 */
	public function set($key){
		//TODO write this
	}
}
