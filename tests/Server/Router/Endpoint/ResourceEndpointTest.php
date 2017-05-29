<?php
namespace LunixREST\Server\Router\Endpoint;

use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateAPIResponseDataException;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateResourceParametersException;
use PHPUnit\Framework\TestCase;

class ResourceEndpointTest extends TestCase
{
    protected function expectResourceFactoryToThrowExceptionWhenAbstractThrowsException($exceptionName, $methodName): ResourceEndpoint
    {
        $resourceParams = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParameters')->getMock();
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParametersFactory')->getMock();
        $paramsFactory->method('createResourceParameters')->willReturn($resourceParams);
        $responseFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory')->getMock();
        $resourceEndpoint = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint')
            ->setConstructorArgs([$paramsFactory, $responseFactory])
            ->getMockForAbstractClass();
        $resourceEndpoint->method($methodName)->willThrowException(new $exceptionName());

        $this->expectException($exceptionName);

        return $resourceEndpoint;
    }

    protected function expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException(): ResourceEndpoint
    {
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParametersFactory')->getMock();
        $paramsFactory->method('createResourceParameters')->willThrowException(new UnableToCreateResourceParametersException());
        $paramsFactory->method('createMultipleResourceParameters')->willThrowException(new UnableToCreateResourceParametersException());
        $responseFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory')->getMock();
        $resourceEndpoint = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint')
            ->setConstructorArgs([$paramsFactory, $responseFactory])
            ->getMockForAbstractClass();

        $this->expectException('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateResourceParametersException');

        return $resourceEndpoint;
    }

    protected function expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException($method, $methodReturn): ResourceEndpoint
    {
        $resourceParams = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParameters')->getMock();
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParametersFactory')->getMock();
        $paramsFactory->method('createResourceParameters')->willReturn($resourceParams);
        $paramsFactory->method('createMultipleResourceParameters')->willReturn([$resourceParams]);
        $responseFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory')->getMockForAbstractClass();
        $responseFactory->method('toAPIResponseData')->willThrowException(new UnableToCreateAPIResponseDataException());
        $resourceEndpoint = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint')
            ->setConstructorArgs([$paramsFactory, $responseFactory])
            ->getMockForAbstractClass();
        $resourceEndpoint->method($method)->willReturn($methodReturn);

        $this->expectException('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateAPIResponseDataException');

        return $resourceEndpoint;
    }

    public function testGetThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->get($apiRequest);
    }

    public function testGetThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('getResource', $resource);

        $resourceEndpoint->get($apiRequest);
    }

    public function testGetThrowsExceptionWhenGetResourceThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'getResource'
        );

        $resourceEndpoint->get($apiRequest);
    }

    public function testGetThrowsExceptionWhenGetResourceThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'getResource'
        );

        $resourceEndpoint->get($apiRequest);
    }

    public function testGetThrowsExceptionWhenGetResourceThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'getResource'
        );

        $resourceEndpoint->get($apiRequest);
    }

    public function testGetThrowsExceptionWhenGetResourceThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'getResource'
        );

        $resourceEndpoint->get($apiRequest);
    }

    public function testGetAllThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->getAll($apiRequest);
    }

    public function testGetAllThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('getResources', [$resource]);

        $resourceEndpoint->getAll($apiRequest);
    }

    public function testGetAllThrowsExceptionWhenGetResourcesThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'getResources'
        );

        $resourceEndpoint->getAll($apiRequest);
    }

    public function testGetAllThrowsExceptionWhenGetResourcesThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'getResources'
        );

        $resourceEndpoint->getAll($apiRequest);
    }

    public function testGetAllThrowsExceptionWhenGetResourcesThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'getResources'
        );

        $resourceEndpoint->getAll($apiRequest);
    }

    public function testGetAllThrowsExceptionWhenGetResourcesThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'getResources'
        );

        $resourceEndpoint->getAll($apiRequest);
    }

    public function testPostThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->post($apiRequest);
    }

    public function testPostThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('postResource', $resource);

        $resourceEndpoint->post($apiRequest);
    }

    public function testPostThrowsExceptionWhenPostResourceThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'postResource'
        );

        $resourceEndpoint->post($apiRequest);
    }

    public function testPostThrowsExceptionWhenPostResourceThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'postResource'
        );

        $resourceEndpoint->post($apiRequest);
    }

    public function testPostThrowsExceptionWhenPostResourceThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'postResource'
        );

        $resourceEndpoint->post($apiRequest);
    }

    public function testPostThrowsExceptionWhenPostResourceThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'postResource'
        );

        $resourceEndpoint->post($apiRequest);
    }

    public function testPostThrowsExceptionWhenPostResourceThrowsElementConflictException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException',
            'postResource'
        );

        $resourceEndpoint->post($apiRequest);
    }

    public function testPostAllThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->postAll($apiRequest);
    }

    public function testPostAllThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('postResources', $resource);

        $resourceEndpoint->postAll($apiRequest);
    }

    public function testPostAllThrowsExceptionWhenPostResourcesThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'postResources'
        );

        $resourceEndpoint->postAll($apiRequest);
    }

    public function testPostAllThrowsExceptionWhenPostResourcesThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'postResources'
        );

        $resourceEndpoint->postAll($apiRequest);
    }

    public function testPostAllThrowsExceptionWhenPostResourcesThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'postResources'
        );

        $resourceEndpoint->postAll($apiRequest);
    }

    public function testPostAllThrowsExceptionWhenPostResourcesThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'postResources'
        );

        $resourceEndpoint->postAll($apiRequest);
    }

    public function testPostAllThrowsExceptionWhenPostResourcesThrowsElementConflictException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException',
            'postResources'
        );

        $resourceEndpoint->postAll($apiRequest);
    }

    public function testPutThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->put($apiRequest);
    }

    public function testPutThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('putResource', $resource);

        $resourceEndpoint->put($apiRequest);
    }

    public function testPutThrowsExceptionWhenPutResourceThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'putResource'
        );

        $resourceEndpoint->put($apiRequest);
    }

    public function testPutThrowsExceptionWhenPutResourceThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'putResource'
        );

        $resourceEndpoint->put($apiRequest);
    }

    public function testPutThrowsExceptionWhenPutResourceThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'putResource'
        );

        $resourceEndpoint->put($apiRequest);
    }

    public function testPutThrowsExceptionWhenPutResourceThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'putResource'
        );

        $resourceEndpoint->put($apiRequest);
    }

    public function testPutThrowsExceptionWhenPutResourceThrowsElementConflictException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException',
            'putResource'
        );

        $resourceEndpoint->put($apiRequest);
    }

    public function testPutAllThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->putAll($apiRequest);
    }

    public function testPutAllThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('putResources', [$resource]);

        $resourceEndpoint->putAll($apiRequest);
    }

    public function testPutAllThrowsExceptionWhenPutResourcesThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'putResources'
        );

        $resourceEndpoint->putAll($apiRequest);
    }

    public function testPutAllThrowsExceptionWhenPutResourcesThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'putResources'
        );

        $resourceEndpoint->putAll($apiRequest);
    }

    public function testPutAllThrowsExceptionWhenPutResourcesThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'putResources'
        );

        $resourceEndpoint->putAll($apiRequest);
    }

    public function testPutAllThrowsExceptionWhenPutResourcesThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'putResources'
        );

        $resourceEndpoint->putAll($apiRequest);
    }

    public function testPutAllThrowsExceptionWhenPutResourcesThrowsElementConflictException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException',
            'putResources'
        );

        $resourceEndpoint->putAll($apiRequest);
    }

    public function testPatchThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->patch($apiRequest);
    }

    public function testPatchThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('patchResource', $resource);

        $resourceEndpoint->patch($apiRequest);
    }

    public function testPatchThrowsExceptionWhenPatchResourceThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'patchResource'
        );

        $resourceEndpoint->patch($apiRequest);
    }

    public function testPatchThrowsExceptionWhenPatchResourceThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'patchResource'
        );

        $resourceEndpoint->patch($apiRequest);
    }

    public function testPatchThrowsExceptionWhenPatchResourceThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'patchResource'
        );

        $resourceEndpoint->patch($apiRequest);
    }

    public function testPatchThrowsExceptionWhenPatchResourceThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'patchResource'
        );

        $resourceEndpoint->patch($apiRequest);
    }

    public function testPatchThrowsExceptionWhenPatchResourceThrowsElementConflictException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException',
            'patchResource'
        );

        $resourceEndpoint->patch($apiRequest);
    }

    public function testPatchAllThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->patchAll($apiRequest);
    }

    public function testPatchAllThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('patchResources', [$resource]);

        $resourceEndpoint->patchAll($apiRequest);
    }

    public function testPatchAllThrowsExceptionWhenPatchResourcesThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'patchResources'
        );

        $resourceEndpoint->patchAll($apiRequest);
    }

    public function testPatchAllThrowsExceptionWhenPatchResourcesThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'patchResources'
        );

        $resourceEndpoint->patchAll($apiRequest);
    }

    public function testPatchAllThrowsExceptionWhenPatchResourcesThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'patchResources'
        );

        $resourceEndpoint->patchAll($apiRequest);
    }

    public function testPatchAllThrowsExceptionWhenPatchResourcesThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'patchResources'
        );

        $resourceEndpoint->patchAll($apiRequest);
    }

    public function testPatchAllThrowsExceptionWhenPatchResourcesThrowsElementConflictException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException',
            'patchResources'
        );

        $resourceEndpoint->patchAll($apiRequest);
    }

    public function testOptionsThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->options($apiRequest);
    }

    public function testOptionsThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('optionsResource', $resource);

        $resourceEndpoint->options($apiRequest);
    }

    public function testOptionsThrowsExceptionWhenOptionsResourceThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'optionsResource'
        );

        $resourceEndpoint->options($apiRequest);
    }

    public function testOptionsThrowsExceptionWhenOptionsResourceThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'optionsResource'
        );

        $resourceEndpoint->options($apiRequest);
    }

    public function testOptionsThrowsExceptionWhenOptionsResourceThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'optionsResource'
        );

        $resourceEndpoint->options($apiRequest);
    }

    public function testOptionsThrowsExceptionWhenOptionsResourceThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'optionsResource'
        );

        $resourceEndpoint->options($apiRequest);
    }

    public function testOptionsThrowsExceptionWhenOptionsResourceThrowsElementConflictException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException',
            'optionsResource'
        );

        $resourceEndpoint->options($apiRequest);
    }

    public function testOptionsAllThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->optionsAll($apiRequest);
    }

    public function testOptionsAllThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('optionsResources', [$resource]);

        $resourceEndpoint->optionsAll($apiRequest);
    }

    public function testOptionsAllThrowsExceptionWhenOptionsResourcesThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'optionsResources'
        );

        $resourceEndpoint->optionsAll($apiRequest);
    }

    public function testOptionsAllThrowsExceptionWhenOptionsResourcesThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'optionsResources'
        );

        $resourceEndpoint->optionsAll($apiRequest);
    }

    public function testOptionsAllThrowsExceptionWhenOptionsResourcesThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'optionsResources'
        );

        $resourceEndpoint->optionsAll($apiRequest);
    }

    public function testOptionsAllThrowsExceptionWhenOptionsResourcesThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'optionsResources'
        );

        $resourceEndpoint->optionsAll($apiRequest);
    }

    public function testOptionsAllThrowsExceptionWhenOptionsResourcesThrowsElementConflictException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException',
            'optionsResources'
        );

        $resourceEndpoint->optionsAll($apiRequest);
    }
    public function testDeleteThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->delete($apiRequest);
    }

    public function testDeleteThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('deleteResource', $resource);

        $resourceEndpoint->delete($apiRequest);
    }

    public function testDeleteThrowsExceptionWhenDeleteResourceThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'deleteResource'
        );

        $resourceEndpoint->delete($apiRequest);
    }

    public function testDeleteThrowsExceptionWhenDeleteResourceThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'deleteResource'
        );

        $resourceEndpoint->delete($apiRequest);
    }

    public function testDeleteThrowsExceptionWhenDeleteResourceThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'deleteResource'
        );

        $resourceEndpoint->delete($apiRequest);
    }

    public function testDeleteThrowsExceptionWhenDeleteResourceThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'deleteResource'
        );

        $resourceEndpoint->delete($apiRequest);
    }

    public function testDeleteAllThrowsExceptionWhenParamFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenParamFactoryThrowsException();

        $resourceEndpoint->deleteAll($apiRequest);
    }

    public function testDeleteAllThrowsExceptionWhenResponseFactoryThrowsException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenResponseFactoryThrowsException('deleteResources', [$resource]);

        $resourceEndpoint->deleteAll($apiRequest);
    }

    public function testDeleteAllThrowsExceptionWhenDeleteResourcesThrowsEndpointExecutionException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException',
            'deleteResources'
        );

        $resourceEndpoint->deleteAll($apiRequest);
    }

    public function testDeleteAllThrowsExceptionWhenDeleteResourcesThrowsUnsupportedMethodException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException',
            'deleteResources'
        );

        $resourceEndpoint->deleteAll($apiRequest);
    }

    public function testDeleteAllThrowsExceptionWhenDeleteResourcesThrowsElementNotFoundException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException',
            'deleteResources'
        );

        $resourceEndpoint->deleteAll($apiRequest);
    }

    public function testDeleteAllThrowsExceptionWhenDeleteResourcesThrowsInvalidRequestException()
    {
        $apiRequest = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();

        $resourceEndpoint = $this->expectResourceFactoryToThrowExceptionWhenAbstractThrowsException(
            '\LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException',
            'deleteResources'
        );

        $resourceEndpoint->deleteAll($apiRequest);
    }

}
