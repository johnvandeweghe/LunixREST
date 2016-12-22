<?php
namespace LunixREST\APIRequest;

class APIRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateRequestWithInstanceFromConstructor()
    {
        $requestMethod = 'get';
        $requestEndpoint = 'helloworld';
        $requestElement = '1000';
        $requestAcceptableMIMETypes = ['application/json'];
        $requestVersion = '1.0';
        $requestAPIKey = 'public';
        $requestQueryString = "hi=world";
        $requestData = ['dasdasdasd'=>'asdasd'];

        $request = new APIRequest($requestMethod, $requestEndpoint, $requestElement, $requestAcceptableMIMETypes,
            $requestVersion, $requestAPIKey, $requestQueryString, $requestData);

        $this->assertEquals($requestMethod, $request->getMethod());
        $this->assertEquals($requestEndpoint, $request->getEndpoint());
        $this->assertEquals($requestElement, $request->getElement());
        $this->assertEquals($requestAcceptableMIMETypes, $request->getAcceptableMIMETypes());
        $this->assertEquals($requestVersion, $request->getVersion());
        $this->assertEquals($requestAPIKey, $request->getApiKey());
        $this->assertEquals($requestQueryString, $request->getQueryData());
        $this->assertEquals($requestData, $request->getData());
    }
}
