<?php
namespace LunixREST\Server;

use LunixREST\Endpoint\Exceptions\UnknownEndpointException;
use LunixREST\Exceptions\AccessDeniedException;
use LunixREST\Exceptions\InvalidAPIKeyException;
use LunixREST\Exceptions\ThrottleLimitExceededException;
use LunixREST\Request\RequestFactory\RequestFactory;
use LunixREST\Request\URLParser\Exceptions\InvalidRequestURLException;
use LunixREST\Response\Exceptions\UnknownResponseTypeException;

//TODO: Unit test? Might be impossible (this is a weird global class, and hopefully the ONLY weird global class)
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
    //TODO: Add logging that we can pass through to log requests
    public function __construct(Server $server, RequestFactory $requestFactory) {
        $this->server = $server;
        $this->requestFactory = $requestFactory;
    }

    public function handleSAPIRequest() {
        try {
            $request = $this->requestFactory->create($_SERVER['REQUEST_METHOD'], getallheaders(),
                file_get_contents("php://input"), $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);

            try {
                $response = $this->server->handleRequest($request);
                echo $response->getAsString();
            } catch(InvalidAPIKeyException $e){
                header('400 Bad Request', true, 400);
            } catch(UnknownEndpointException $e){
                header('404 Not Found', true, 404);
            } catch(UnknownResponseTypeException $e){
                header('404 Not Found', true, 404);
            } catch(AccessDeniedException $e){
                header('403 Access Denied', true, 403);
            } catch(ThrottleLimitExceededException $e){
                header('429 Too Many Requests', true, 429);
            } catch (\Exception $e) {
                header('500 Internal Server Error', true, 500);
            }
        } catch(InvalidRequestURLException $e){
            header('400 Bad Request', true, 400);
        } catch(\Exception $e){
            header('500 Internal Server Error', true, 500);
        }
    }
}
