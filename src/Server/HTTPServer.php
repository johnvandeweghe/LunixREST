<?php
namespace LunixREST\Server;

use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidAPIKeyException;
use LunixREST\Exceptions\ThrottleLimitExceededException;
use LunixREST\Request\BodyParser\BodyParserFactory\Exceptions\UnknownContentTypeException;
use LunixREST\Request\BodyParser\Exceptions\InvalidRequestDataException;
use LunixREST\Request\RequestFactory\RequestFactory;
use LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\Response\Exceptions\NotAcceptableResponseTypeException;
use LunixREST\Server\Exceptions\MethodNotFoundException;

class HTTPServer {
    /**
     * @var Server
     */
    protected $server;
    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * HTTPServer constructor.
     * @param Server $server
     * @param RequestFactory $requestFactory
     */
    //TODO: Add RequestLogger that we can pass through to log requests
    //TODO: Add ErrorLogger to log errors (500s)
    public function __construct(Server $server, RequestFactory $requestFactory) {
        $this->server = $server;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @param $requestMethod - gotten from $_SERVER['REQUEST_METHOD'] for example
     * @param $headers - gotten from getallheaders() for example
     * @param $data - gotten from file_get_contents("php://input") for example
     * @param $remoteAddress - gotten from $_SERVER['REMOTE_ADDR'] for example
     * @param $requestURI - gotten from $_SERVER['REQUEST_URI'] for example
     * Prints out the server response data, and sets any needed HTTP headers based on exceptions
     */
    public function handleSAPIRequest($requestMethod, $headers, $data, $remoteAddress, $requestURI) {
        try {
            $request = $this->requestFactory->create($requestMethod, $headers(), $data, $remoteAddress, $requestURI);

            try {
                $response = $this->server->handleRequest($request);
                header("Content-Type: " . $response->getMIMEType());
                //TODO: Find a way for the Response to specify additional headers (to enable auth, as well as pagination)
                echo $response->getAsString();
            } catch(InvalidAPIKeyException $e){
                header('400 Bad Request', true, 400);
            } catch(UnknownEndpointException $e){
                header('404 Not Found', true, 404);
            } catch(NotAcceptableResponseTypeException $e){
                header('406 Not Acceptable', true, 406);
            } catch(AccessDeniedException $e){
                header('403 Access Denied', true, 403);
            } catch(ThrottleLimitExceededException $e){
                header('429 Too Many Requests', true, 429);
            } catch (MethodNotFoundException $e) {
                header('500 Internal Server Error', true, 500);
            } catch (\Exception $e) {
                header('500 Internal Server Error', true, 500);
            }
        } catch(InvalidRequestURLException $e){
            header('400 Bad Request', true, 400);
        } catch(UnknownContentTypeException $e){
            header('400 Bad Request', true, 400);
        } catch(InvalidRequestDataException $e){
            header('400 Bad Request', true, 400);
        } catch(\Exception $e){
            header('500 Internal Server Error', true, 500);
        }
    }
}
