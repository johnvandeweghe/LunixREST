<?php
namespace LunixREST\Configuration;

use LunixREST\Exceptions\INIKeyNotFoundException;
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
	 * @throws INIKeyNotFoundException
	 * @throws INIParseException
	 */
	public function get($key){
		$config = parse_ini_file($this->filename, (bool)$this->nameSpace);

		if($config === false){
			throw new INIParseException('Could not parse: ' . $this->filename, true);
		}

		if($this->nameSpace) {
			if(isset($config[$this->nameSpace])) {
				$config = $config[$this->nameSpace];
			} else {
				throw new INIKeyNotFoundException();
			}
		}

		return isset($config[$key]) ? $config[$key] : null;
	}

	/**
	 * @param $key
	 */
	public function set($key){
		//TODO write this
	}
}