[![Build Status](https://travis-ci.org/johnvandeweghe/LunixREST.svg?branch=master)](https://travis-ci.org/johnvandeweghe/LunixREST) [![Code Coverage](https://scrutinizer-ci.com/g/johnvandeweghe/LunixREST/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/johnvandeweghe/LunixREST/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnvandeweghe/LunixREST/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnvandeweghe/LunixREST/?branch=master)

# Overview

LunixREST is a highly extensible, lightweight library for writing REST APIs in PHP (7.1+).

It's primary goal is to allow the creation of a REST API in which every part of it's behaviour can be overwritten without any code hacks. Because of this, it's generally very compatible with existing codebases.

## Features
- API key access control
- Routing to endpoints
- API versioning
- API Access throttling
- PSR-2 styled
- PSR-3 (logging) compatible
- PSR-4 (autoloading) compatible
- PSR-6 (caching) compatible
- PSR-7 (http) compatible
- Versatile output formatting

See https://github.com/johnvandeweghe/LunixREST-Basics for some basic implementations, and examples.

# Installation
## Requirements
All dependencies are specified in the composer.json, so as long as you use composer with this library, all dependencies should be taken care of.

That being said, here are some dependencies:
* PHP 7.1+
* php-mbstring
* PSR/Cache
* PSR/HTTP-Message
* PSR/Log

## Version Notice
This project updates master regularly. Changes to master that are not released are not guaranteed to be stable, and should be treated as such. Use the release tags for production projects.

All minor version number updates will have guaranteed backwards compatibility. Major version changes won't be held to that standard, but generally the goal is to minimise interface changes.

## Installation

This project is listed in [Packigist](https://packagist.org/packages/johnvandeweghe/lunixrest), the default repository for Composer. So installation is as simple as:

``` composer require johnvandeweghe/lunixrest ```

# Usage

## HTTPServer
The basis of an implementation of LunixREST is the class HTTPServer. This class takes in a PSR-7 ServerRequestInterface and returns a ResponseInterface that can be dumped to the SAPI.

Here is an example that uses Guzzle's PSR-7 implementation.
```php
$httpServer = new \LunixREST\Server\HTTPServer($server, $requestFactory, $logger);

$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

\LunixREST\Server\HTTPServer::dumpResponse($httpServer->handleRequest($serverRequest, new GuzzleHttp\Psr7\Response()));
```

Looks pretty simple, except for the obvious missing variable definitions of ```$server```, ```$requestFactory```, and ```$logger```.
An HTTPServer requires these to be constructed, so lets build them one at a time as an example.
### Server/GenericServer
A Server's jobs is to take in a APIRequest generated by the HTTPServer, an return an APIResponse (or throw an exception, if applicable to the request)

But Server is an interface, so we'll need a specific implementation to use. In this example we'll be using a GenericServer.

```php
$server = new GenericServer($accessControl, $throttle, $responseFactory, $router);
```

Again, simple, but we're missing some definitions, so lets break those down one-by-one.

#### AccessControl/PublicAccessControl

A GenericServer requires an AccessControl instance to handle controlling access.

For example, a PublicAccessControl takes in a request and says that it is allowed, without checking it at all. As the name implies, it's for a public API, and ignores the key entirely.

```php
$accessControl = new PublicAccessControl();
```

#### Throttle/NoThrottle

A GenericServer also requires a Throttle instance to handling throttling requests if needed.

For example, a NoThrottle just returns that a given request doesn't need to be throttled, ever. Less applicable to real API implementations, beyond smaller ones. Actual implementations of Throttle will be able to be found in LunixREST-Basics.

```php
$throttle = new NoThrottle();
```
#### ResponseFactory/RegisteredResponseFactory

Another thing that a GenericServer requires is an instance of a ResponseFactory, which it uses to form the APIResponseData into an APIResponse. A key feature to this is transforming the data in an APIResponseData object and converting it into an PSR-7 StreamInterface.

For example, a RegisteredResponseFactory takes in a list of APIResponseDataSerializers and associates them with a specific MIME type.

```php
$responseFactory = new \LunixREST\APIResponse\RegisteredResponseFactory([
    'application/json' => new \LunixRESTBasics\APIResponse\JSONResponseDataSerializer()
]);
```

You'll notice that the JSONResponseDataSerializer is in the LunixREST-Basics project. This is because it requires a specific PSR-7 implementation (it uses Guzzle's). No actual implementations of APIResponseDataSerializer are included in Core because of this reason. 

#### Router/GenericRouter

The final thing that a GenericServer needs to function is a Router. A Router takes a request and decides which Endpoint and method on that Endpoint to call. It then proceeds to call the endpoint and return the result.

For example:

TODO:

##### EndpointFactory/SingleEndpointFactory

### RequestFactory

### LoggerInterface
