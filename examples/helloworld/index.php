<?php
require("vendor/autoload.php");
//So we can use the namespace endpoint factory
require("src/Endpoints/v1_0/helloworld.php");

use LunixREST\AccessControl\PublicAccessControl;
use LunixREST\Endpoint\NamespaceEndpointFactory;
use LunixREST\APIRequest\RequestFactory\BasicRequestFactory;
use LunixREST\APIResponse\DefaultResponseFactory;
use LunixREST\Server\GenericServer;
use LunixREST\Server\HTTPServer;
use LunixREST\Server\Server;
use LunixREST\Throttle\NoThrottle;

//Ignore whatever key is passed and give access anyway
$accessControl = new PublicAccessControl();

//Don't throttle requests
$throttle = new NoThrottle();

//Lets support the default response types (JSON)
$responseFactory = new DefaultResponseFactory();

//Load any endpoints from the namespace listed
$endpointFactory = new NamespaceEndpointFactory("\\HelloWorld\\Endpoints");

$router = new \LunixREST\Server\GenericRouter($endpointFactory);

$server = new GenericServer($accessControl, $throttle, $responseFactory, $router);

//Build a basic request factory, which includes the basic url parser (which determines the url format)
$requestFactory = new BasicRequestFactory();

$httpServer = new HTTPServer($server, $requestFactory);

$serverRequest = GuzzleHttp\

//Run to test: GET /1.0/public/helloworld.json
$httpServer->handleSAPIRequest($_SERVER['REQUEST_METHOD'], getallheaders(), file_get_contents("php://input"),
    $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);
