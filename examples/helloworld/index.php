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
	header('404 Not Found', 404);
} catch(\LunixREST\Exceptions\UnknownResponseFormatException $e){
	header('404 Not Found', 404);
} catch(\LunixREST\Exceptions\AccessDeniedException $e){
	header('403 Access Denied', 403);
} catch(\LunixREST\Exceptions\InvalidResponseFormatException $e){
	header('500 Internal Server Error', 500);
} catch(Exception $e){
	header('500 Internal Server Error', 500);
}