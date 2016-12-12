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

$accessControl = new AllAccessConfigurationListAccessControl(new INIConfiguration("config/api_keys.ini"), 'keys');
$throttle = new NoThrottle();
$responseFactory = new DefaultResponseFactory();
$geoPhone = new GeoPhone("data.csv");
$endpointFactory = new EndpointFactory($geoPhone);
$server = new Server($accessControl, $throttle, $responseFactory, $endpointFactory);

$requestFactory = new BasicURLEncodedRequestFactory();

$httpServer = new HTTPServer($server, $requestFactory);

// Run to test: GET /1/123456/phonenumbers/6517855237.json
$httpServer->handleSAPIRequest();
