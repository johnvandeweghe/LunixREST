<?php
use GeoPhone\EndpointFactory\EndpointFactory;
use GeoPhone\Models\GeoPhone;
use LunixREST\AccessControl\AllAccessConfigurationListAccessControl;
use LunixREST\Configuration\INIConfiguration;
use LunixREST\Request\RequestFactory\BasicURLEncodedRequestFactory;
use LunixREST\Response\DefaultResponseFactory;
use LunixREST\Server\HTTPServer;
use LunixREST\Server\Server;
use LunixREST\Throttle\NoThrottle;

require("vendor/autoload.php");

//Load an access control that gives full access to every key in config/api_keys.ini
$accessControl = new AllAccessConfigurationListAccessControl(new INIConfiguration("config/api_keys.ini"), 'keys');

//Don't throttle requests
$throttle = new NoThrottle();

//Lets support the default response types (JSON)
$responseFactory = new DefaultResponseFactory();

//Load in a global data model that we can use when handling requests (similar to connecting to a db)
$geoPhone = new GeoPhone("data.csv");

//Build an endpoint factory to find the requested endpoint
$endpointFactory = new EndpointFactory($geoPhone);

$server = new Server($accessControl, $throttle, $responseFactory, $endpointFactory);

//Build a basic url decoding body handler, which includes the basic url parser (which determines the url format)
$requestFactory = new BasicURLEncodedRequestFactory();

$httpServer = new HTTPServer($server, $requestFactory);

//Run to test: GET /1/123456/phonenumbers/6517855237.json
$httpServer->handleSAPIRequest();
