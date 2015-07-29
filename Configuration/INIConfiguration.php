<?php
namespace LunixREST\Configuration;

use LunixREST\Exceptions\INIParseException;

abstract class INIConfiguration implements Configuration {
	protected $nameSpace;

	public function __construct($nameSpace){
		$this->nameSpace = $nameSpace;
	}
	
	public function get($key){
		$config = parse_ini_file($this->getFilePath());

		if(!$config){
			throw new INIParseException('Could not parse: ' . $this->getFilePath(), true);
		}

		if($this->nameSpace) {
			return $config[$this->nameSpace][$key];
		} else {
			return $config[$key];
		}
	}
	
	public function set($key){
		//TODO write this
	}

	abstract protected function getFilePath();
}
