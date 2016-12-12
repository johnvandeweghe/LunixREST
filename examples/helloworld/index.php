<?php
require("vendor/autoload.php");
//So we can use the namespace endpoint factory
require("src/Endpoints/v1_0/helloworld.php");

use LunixREST\AccessControl\PublicAccessControl;
use LunixREST\Endpoint\NamespaceEndpointFactory;
use LunixREST\Request\RequestFactory\BasicURLEncodedRequestFactory;
use LunixREST\Response\DefaultResponseFactory;
use LunixREST\Server\HTTPServer;
use LunixREST\Server\Server;
use LunixREST\Throttle\NoThrottle;

$accessControl = new PublicAccessControl("public");
$throttle = new NoThrottle();
$responseFactory = new DefaultResponseFactory();
$endpointFactory = new NamespaceEndpointFactory("\\HelloWorld\\Endpoints");

$server = new Server($accessControl, $throttle, $responseFactory, $endpointFactory);

$requestFactory = new BasicURLEncodedRequestFactory();

$httpServer = new HTTPServer($server, $requestFactory);

// Run to test: GET /1.0/public/helloworld.json

$httpServer->handleSAPIRequest();
