<?php
require("vendor/autoload.php");

require("Endpoints/v1_0/helloworld.php");

$accessControl = new \LunixREST\AccessControl\PublicAccessControl("public");
$throttle = new \LunixREST\Throttle\NoThrottle();
$formatsConfig = new \LunixREST\Configuration\INIConfiguration("config/formats.ini");
$router = new \LunixREST\Router\Router($accessControl, $throttle, $formatsConfig, "HelloWorld");

try {
	$request =  \LunixREST\Request\Request::createFromURL("GET", [], [], '127.0.0.1', "/1.0/public/helloworld.json");// \LunixREST\Request\Request::createFromURL($_SERVER['REQUEST_METHOD'], getallheaders(), $_REQUEST, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);

	try {
		echo $router->handle($request);
	} catch(\LunixREST\Exceptions\InvalidAPIKeyException $e){
		header('400 Bad Request', true, 400);
	} catch(\LunixREST\Exceptions\UnknownEndpointException $e){
		header('404 Not Found', true, 404);
	} catch(\LunixREST\Exceptions\UnknownResponseFormatException $e){
		header('404 Not Found', true, 404);
	} catch(\LunixREST\Exceptions\AccessDeniedException $e){
		header('403 Access Denied', true, 403);
	}  catch(\LunixREST\Exceptions\ThrottleLimitExceededException $e){
		header('429 Too Many Requests', true, 429);
	} catch(\LunixREST\Exceptions\InvalidResponseFormatException $e){
		header('500 Internal Server Error', true, 500);
	} catch(Exception $e){
		header('500 Internal Server Error', true, 500);
	}
} catch(\LunixREST\Exceptions\InvalidRequestFormatException $e){
	header('400 Bad Request', true, 400);
} catch(Exception $e){
	header('500 Internal Server Error', true, 500);
}
