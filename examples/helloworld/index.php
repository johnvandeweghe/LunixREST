<?php
require("vendor/autoload.php");
//So we can use the namespace endpoint factory
require("src/Endpoints/v1_0/helloworld.php");

use LunixREST\AccessControl\PublicAccessControl;
use LunixREST\Endpoint\NamespaceEndpointFactory;
use LunixREST\Request\RequestFactory\BasicRequestFactory;
use LunixREST\Response\DefaultResponseFactory;
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

$server = new Server($accessControl, $throttle, $responseFactory, $endpointFactory);

//Build a basic url decoding body handler, which includes the basic url parser (which determines the url format)
$requestFactory = new BasicRequestFactory();

$httpServer = new HTTPServer($server, $requestFactory);

//Run to test: GET /1.0/public/helloworld.json
$httpServer->handleSAPIRequest();
