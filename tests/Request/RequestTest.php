<?php
namespace LunixREST\tests\AccessControl;

use LunixREST\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {
    public function testConstruct(){
        //URL test
        $request = new Request('get', [], [], '', '/1.0/public/helloworld/1000.json');

        $this->assertEquals('1.0', $request->getVersion(), 'version should be parsed out of URLS');
        $this->assertEquals('public', $request->getApiKey(), 'api key should be parsed out of URLS');
        $this->assertEquals('helloworld', $request->getEndpoint(), 'endpoint should be parsed out of URLS');
        $this->assertEquals('1000', $request->getInstance(), 'instance should be parsed out of URLS');
        $this->assertEquals('json', $request->getExtension(), 'extension should be parsed out of URLS');
        $this->assertEquals('get', $request->getMethod(), 'method with instance should be parsed out of URLS');

        $request = new Request('get', [], [], '', '/1.0/public/helloworld.json');
        $this->assertEquals('getAll', $request->getMethod(), 'method without instance should be parsed out of URLS');

        //No url test
        $request = new Request('get', [], [], '', null, '1.0', 'public', 'helloworld', 'json', '1000');

        $this->assertEquals('1.0', $request->getVersion(), 'version should be set without a URL');
        $this->assertEquals('public', $request->getApiKey(), 'api key should be set without a URL');
        $this->assertEquals('helloworld', $request->getEndpoint(), 'endpoint should be set without a URL');
        $this->assertEquals('1000', $request->getInstance(), 'instance should be set without a URL');
        $this->assertEquals('json', $request->getExtension(), 'extension should be set without a URL');
        $this->assertEquals('get', $request->getMethod(), 'method with instance should be set without a URL');

        $request = new Request('get', [], [], '', null, '1.0', 'public', 'helloworld', 'json');
        $this->assertEquals('getAll', $request->getMethod(), 'method without instance should be set without a URL');

        //both test
        $request = new Request('get', [], [], '', '/2.1/private/goodbyeworld/2000.json', '1.0', 'public', 'helloworld', 'json', '1000');

        $this->assertEquals('1.0', $request->getVersion(), 'version should be set without a URL');
        $this->assertEquals('public', $request->getApiKey(), 'api key should be set without a URL');
        $this->assertEquals('helloworld', $request->getEndpoint(), 'endpoint should be set without a URL');
        $this->assertEquals('1000', $request->getInstance(), 'instance should be set without a URL');
        $this->assertEquals('json', $request->getExtension(), 'extension should be set without a URL');
        $this->assertEquals('get', $request->getMethod(), 'method with instance should be set without a URL');

        $request = new Request('get', [], [], '', '/2.1/private/goodbyeworld.json', '1.0', 'public', 'helloworld', 'json');
        $this->assertEquals('getAll', $request->getMethod(), 'method without instance should be set without a URL');

        //neither test
        $this->setExpectedException('\LunixREST\Exceptions\InvalidRequestFormatException');
        new Request('get', [], [], '', null);
    }
}