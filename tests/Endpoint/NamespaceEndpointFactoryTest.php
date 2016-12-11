<?php
namespace LunixREST\tests\Endpoint;

use LunixREST\Endpoint\NamespaceEndpointFactory;

class NamespaceEndpointFactoryTest extends \PHPUnit_Framework_TestCase {
    protected $version = "1";
    protected $namespace = "TestNameSpace\\Endpoints";
    protected $defaultEndpointClassname = "\\LunixREST\\Endpoint\\DefaultEndpoint";
    protected $classname = "HelloPoint";
    protected $fullClassname;

    public function setUp() {
        $this->fullClassname = "{$this->namespace}\\v{$this->version}\\{$this->classname}";
        if(!class_exists($this->fullClassname)) {
            eval("namespace {$this->namespace}\\v{$this->version}; class {$this->classname} extends {$this->defaultEndpointClassname} {}");
        }
    }

    public function testGettingValidEndpoint() {
        $namespaceEndpointFactory = new NamespaceEndpointFactory($this->namespace);

        $this->assertInstanceOf($this->defaultEndpointClassname, $namespaceEndpointFactory->getEndpoint($this->classname, $this->version));
    }

    public function testGettingInvalidEndpoint() {
        $emptyNamespace = "TestNameSpace\\NotEndpoints";

        $namespaceEndpointFactory = new NamespaceEndpointFactory($emptyNamespace);

        $this->setExpectedException('\\LunixREST\Endpoint\Exceptions\UnknownEndpointException');
        $namespaceEndpointFactory->getEndpoint($this->classname, $this->version);
    }

    public function testGettingSupportedEndpointsWithOne() {
        $namespaceEndpointFactory = new NamespaceEndpointFactory($this->namespace);

        $this->assertEquals([$this->fullClassname], $namespaceEndpointFactory->getSupportedEndpoints($this->version));
    }

    public function testGettingSupportedEndpointsWithNoneBecauseNamespace() {
        $emptyNamespace = "TestNameSpace\\NotEndpoints";

        $namespaceEndpointFactory = new NamespaceEndpointFactory($emptyNamespace);

        $this->assertEmpty($namespaceEndpointFactory->getSupportedEndpoints($this->version));
    }

    public function testGettingSupportedEndpointsWithNoneBecauseVersion() {
        $namespaceEndpointFactory = new NamespaceEndpointFactory($this->namespace);

        $this->assertEmpty($namespaceEndpointFactory->getSupportedEndpoints($this->version . "2"));
    }
}
