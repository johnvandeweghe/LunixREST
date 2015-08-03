<?php
require("vendor/autoload.php");

require("helloworld.php");

$request = new \LunixREST\Request\Request("GET", [], "/1.0/123456/helloworld.json", []);//new \LunixREST\Request\Request($_SERVER['REQUEST_METHOD'], getallheaders(), $_SERVER['REQUEST_URI'], $_REQUEST);
$accessControl = new \LunixREST\AccessControl\AllAccessINIAccessControl("config/api_keys.ini");
$outputConfig = new \LunixREST\Configuration\INIConfiguration("config/output.ini");
$formatsConfig = new \LunixREST\Configuration\INIConfiguration("config/formats.ini");

try {
	$router = new \LunixREST\Router\Router($request, $accessControl, $outputConfig, $formatsConfig, "Sample");
	echo $router->handle();
} catch(\LunixREST\Exceptions\UnknownEndPointException $e){
	echo "404";
} catch(\LunixREST\Exceptions\UnknownResponseFormatException $e){
	echo "404";
} catch(\LunixREST\Exceptions\AccessDeniedException $e){
	echo "403";
} catch(\LunixREST\Exceptions\InvalidResponseFormatException $e){
	echo "500";
} catch(Exception $e){
	echo "500";
}