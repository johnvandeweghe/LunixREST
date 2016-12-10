<?php
require("vendor/autoload.php");

require("src/Endpoints/v1/phonenumbers.php");

$accessControl = new \LunixREST\AccessControl\AllAccessConfigurationListAccessControl(new \LunixREST\Configuration\INIConfiguration("config/api_keys.ini"), 'keys');
$throttle = new \LunixREST\Throttle\NoThrottle();
$responseFactory = new \LunixREST\Response\DefaultResponseFactory();
$endpointFactory = new \LunixREST\Endpoint\NamespaceEndpointFactory("\\GeoPhone");
$router = new \LunixREST\Router\Router($accessControl, $throttle, $responseFactory, $endpointFactory);

try {
	$request = \LunixREST\Request\Request::createFromURL("GET", [], [], '127.0.0.1',  "/1/123456/phonenumbers/6517855237.json");// \LunixREST\Request\Request::createFromURL($_SERVER['REQUEST_METHOD'], getallheaders(), $_REQUEST, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);

    try {
        $response = $router->route($request);
        echo $response->getAsString();
    } catch(\LunixREST\Exceptions\InvalidAPIKeyException $e){
        header('400 Bad Request', true, 400);
    } catch(\LunixREST\Endpoint\Exceptions\UnknownEndpointException $e){
        header('404 Not Found', true, 404);
    } catch(\LunixREST\Response\Exceptions\UnknownResponseTypeException $e){
        header('404 Not Found', true, 404);
    } catch(\LunixREST\Exceptions\AccessDeniedException $e){
        header('403 Access Denied', true, 403);
    }  catch(\LunixREST\Exceptions\ThrottleLimitExceededException $e){
        header('429 Too Many Requests', true, 429);
    } catch(Exception|Error $e){
        header('500 Internal Server Error', true, 500);
    }
} catch(\LunixREST\Exceptions\InvalidRequestFormatException $e){
	header('400 Bad Request', 400);
} catch(Exception|Error $e){
	header('500 Internal Server Error', true, 500);
}
