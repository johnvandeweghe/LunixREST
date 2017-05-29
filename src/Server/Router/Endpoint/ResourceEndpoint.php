<?php
namespace LunixREST\Server\Router\Endpoint;

use LunixREST\Server\APIRequest\APIRequest;
use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementConflictException;
use LunixREST\Server\Router\Endpoint\Exceptions\ElementNotFoundException;
use LunixREST\Server\Router\Endpoint\Exceptions\EndpointExecutionException;
use LunixREST\Server\Router\Endpoint\Exceptions\InvalidRequestException;
use LunixREST\Server\Router\Endpoint\Exceptions\UnsupportedMethodException;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateAPIResponseDataException;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateResourceParametersException;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParameters;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParametersFactory;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource;

/**
 * Class ResourceEndpoint
 * @package LunixREST\Server\Router\Endpoint
 */
abstract class ResourceEndpoint implements Endpoint
{
    /**
     * @var ResourceParametersFactory
     */
    protected $resourceParametersFactory;
    /**
     * @var ResourceAPIResponseDataFactory
     */
    protected $resourceAPIResponseDataFactory;

    /**
     * ResourceEndpoint constructor.
     * @param ResourceParametersFactory $parametersFactory
     * @param ResourceAPIResponseDataFactory $APIResponseDataFactory
     */
    public function __construct(
        ResourceParametersFactory $parametersFactory,
        ResourceAPIResponseDataFactory $APIResponseDataFactory
    )
    {
        $this->resourceParametersFactory = $parametersFactory;
        $this->resourceAPIResponseDataFactory = $APIResponseDataFactory;
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function get(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resource = $this->getResource($resourceParameters);

        return $this->resourceAPIResponseDataFactory->toAPIResponseData($resource);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function getAll(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resources = $this->getResources($resourceParameters);

        return $this->resourceAPIResponseDataFactory->multipleToAPIResponseData($resources);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws ElementConflictException
     * @throws InvalidRequestException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function post(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resource = $this->postResource($resourceParameters);

        return $this->resourceAPIResponseDataFactory->toAPIResponseData($resource);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function postAll(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resource = $this->postResources($resourceParameters);

        return $this->resourceAPIResponseDataFactory->toAPIResponseData($resource);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function put(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resource = $this->putResource($resourceParameters);

        return $this->resourceAPIResponseDataFactory->toAPIResponseData($resource);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function putAll(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createMultipleResourceParameters($request);

        $resources = $this->putResources($resourceParameters);

        return $this->resourceAPIResponseDataFactory->multipleToAPIResponseData($resources);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function patch(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resource = $this->patchResource($resourceParameters);

        return $this->resourceAPIResponseDataFactory->toAPIResponseData($resource);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws ElementConflictException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function patchAll(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createMultipleResourceParameters($request);

        $resources = $this->patchResources($resourceParameters);

        return $this->resourceAPIResponseDataFactory->multipleToAPIResponseData($resources);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function options(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resource = $this->optionsResource($resourceParameters);

        return $this->resourceAPIResponseDataFactory->toAPIResponseData($resource);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function optionsAll(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createMultipleResourceParameters($request);

        $resources = $this->optionsResources($resourceParameters);

        return $this->resourceAPIResponseDataFactory->multipleToAPIResponseData($resources);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function delete(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resource = $this->deleteResource($resourceParameters);

        return $this->resourceAPIResponseDataFactory->toAPIResponseData($resource);
    }

    /**
     * @param APIRequest $request
     * @return APIResponseData
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     * @throws UnableToCreateAPIResponseDataException
     * @throws UnableToCreateResourceParametersException
     */
    public function deleteAll(APIRequest $request): APIResponseData
    {
        $resourceParameters = $this->resourceParametersFactory->createResourceParameters($request);

        $resources = $this->deleteResources($resourceParameters);

        return $this->resourceAPIResponseDataFactory->multipleToAPIResponseData($resources);
    }

    /**
     * @param ResourceParameters $parameters
     * @return Resource
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    abstract protected function getResource(ResourceParameters $parameters): Resource;

    /**
     * @param ResourceParameters $parameters
     * @return Resource[]
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    abstract protected function getResources(ResourceParameters $parameters): array;

    /**
     * @param ResourceParameters $parameters
     * @return Resource
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws ElementConflictException
     * @throws InvalidRequestException
     */
    abstract protected function postResource(ResourceParameters $parameters): Resource;

    /**
     * @param ResourceParameters $parameters
     * @return Resource
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementConflictException
     * @throws InvalidRequestException
     */
    abstract protected function postResources(ResourceParameters $parameters): Resource;

    /**
     * @param ResourceParameters $parameters
     * @return Resource
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws ElementConflictException
     * @throws InvalidRequestException
     */
    abstract protected function putResource(ResourceParameters $parameters): Resource;

    /**
     * @param ResourceParameters[] $parameters
     * @return Resource[]
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementConflictException
     * @throws InvalidRequestException
     */
    abstract protected function putResources(array $parameters): array;

    /**
     * @param ResourceParameters $parameters
     * @return Resource
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws ElementConflictException
     * @throws InvalidRequestException
     */
    abstract protected function patchResource(ResourceParameters $parameters): Resource;

    /**
     * @param ResourceParameters[] $parameters
     * @return Resource[]
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws ElementConflictException
     * @throws InvalidRequestException
     */
    abstract protected function patchResources(array $parameters): array;

    /**
     * @param ResourceParameters $parameters
     * @return Resource
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    abstract protected function optionsResource(ResourceParameters $parameters): Resource;

    /**
     * @param ResourceParameters[] $parameters
     * @return Resource[]
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws InvalidRequestException
     */
    abstract protected function optionsResources(array $parameters): array;

    /**
     * @param ResourceParameters $parameters
     * @return Resource|null
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    abstract protected function deleteResource(ResourceParameters $parameters): ?Resource;

    /**
     * @param ResourceParameters $parameters
     * @return Resource[]|null
     * @throws EndpointExecutionException
     * @throws UnsupportedMethodException
     * @throws ElementNotFoundException
     * @throws InvalidRequestException
     */
    abstract protected function deleteResources(ResourceParameters $parameters): ?array;

}
