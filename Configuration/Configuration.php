<?php
namespace LunixREST\Configuration;

interface Configuration {
	public function __construct($nameSpace);
	public function get($key);
	public function set($key);
}
