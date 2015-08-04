<?php
require("vendor/autoload.php");

require("helloworld.php");

$accessControl = new \LunixREST\AccessControl\AllAccessINIAccessControl("config/api_keys.ini");
$outputConfig = new \LunixREST\Configuration\INIConfiguration("config/output.ini");
$formatsConfig = new \LunixREST\Configuration\INIConfiguration("config/formats.ini");
$router = new \LunixREST\Router\Router($accessControl, $outputConfig, $formatsConfig, "Sample");

try {
	$request = new \LunixREST\Request\Request("GET", [], "/1.0/123456/helloworld.json", []);//new \LunixREST\Request\Request($_SERVER['REQUEST_METHOD'], getallheaders(), $_SERVER['REQUEST_URI'], $_REQUEST);

	try {
		echo $router->handle($request);
	} catch(\LunixREST\Exceptions\InvalidRequestFormatException $e){
		header('400 Bad Request', 400);
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
} catch(\LunixREST\Exceptions\InvalidRequestFormatException $e){
	header('400 Bad Request', 400);
} catch(Exception $e){
	header('500 Internal Server Error', 500);
}
