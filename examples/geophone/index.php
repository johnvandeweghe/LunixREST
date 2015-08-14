<?php
require("vendor/autoload.php");

require("Endpoints/v1/phonenumbers.php");

$accessControl = new \LunixREST\AccessControl\AllAccessListAccessControl("config/api_keys.ini");
$throttle = new \LunixREST\Throttle\APIKeySQLiteThrottle('throttle.sqllite', 3);
$formatsConfig = new \LunixREST\Configuration\INIConfiguration("config/formats.ini");
$router = new \LunixREST\Router\Router($accessControl, $throttle, $formatsConfig, "Sample");

try {
	$request = new \LunixREST\Request\Request("GET", [], [], '127.0.0.1',  "/1/123456/phonenumbers/6517855237.json");//new \LunixREST\Request\Request($_SERVER['REQUEST_METHOD'], getallheaders(), $_REQUEST, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);

	try {
		echo $router->handle($request);
	} catch(\LunixREST\Exceptions\InvalidRequestFormatException $e){
		header('400 Bad Request', 400);
	} catch(\LunixREST\Exceptions\UnknownEndpointException $e){
		header('404 Not Found', 404);
	} catch(\LunixREST\Exceptions\UnknownResponseFormatException $e){
		header('404 Not Found', 404);
	} catch(\LunixREST\Exceptions\InstanceNotFoundException $e){
		header('404 Not Found', 404);
	} catch(\LunixREST\Exceptions\AccessDeniedException $e){
		header('403 Access Denied', 403);
	} catch(\LunixREST\Exceptions\ThrottleLimitExceededException $e){
		header('429 Too Many Requests', 429);
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
