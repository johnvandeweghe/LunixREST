<?php
namespace LunixREST\Server\Router\Endpoint\ResourceEndpoint;

use LunixREST\Server\APIResponse\APIResponseData;
use LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateAPIResponseDataException;
use PHPUnit\Framework\TestCase;

class ResourceAPIResponseDataFactoryTest extends TestCase
{
    public function testMultipleToAPIResponseDataCallsToAPIResponseDataWithNullWhenParamIsNull()
    {
        $resources = null;
        $responseDataFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory')
            ->getMockForAbstractClass();

        $responseDataFactory->expects($this->once())->method('toAPIResponseData')->with($resources);

        /** @var ResourceAPIResponseDataFactory $responseDataFactory */
        $responseDataFactory->multipleToAPIResponseData($resources);
    }

    public function testMultipleToAPIResponseDataThrowsExceptionWhenToAPIResponseDataThrowsWhenParamIsNull()
    {
        $resources = null;
        $responseDataFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory')
            ->getMockForAbstractClass();
        $responseDataFactory->method('toAPIResponseData')->with($resources)
            ->willThrowException(new UnableToCreateAPIResponseDataException());

        $this->expectException('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateAPIResponseDataException');

        /** @var ResourceAPIResponseDataFactory $responseDataFactory */
        $responseDataFactory->multipleToAPIResponseData($resources);
    }

    public function testMultipleToAPIResponseDataCallsToAPIResponseDataWithEachResourceWhen0Resources()
    {
        $resources = [];
        $responseDataFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory')
            ->getMockForAbstractClass();
        $responseDataFactory->method('toAPIResponseData');

        /** @var ResourceAPIResponseDataFactory $responseDataFactory */
        $apiResponseData = $responseDataFactory->multipleToAPIResponseData($resources);

        $this->assertEmpty($apiResponseData->getData());
    }

    public function testMultipleToAPIResponseDataCallsToAPIResponseDataWithEachResourceWhen1Resources()
    {
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();
        $resources = [
            $resource
        ];
        $resourceResponseData = [
            ["a"=>"B"]
        ];
        $responseDataFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory')
            ->getMockForAbstractClass();

        foreach($resourceResponseData as $i => $resourceResponseDatum) {
            $responseDataFactory->expects($this->at($i))->method('toAPIResponseData')->with($resource)
                ->willReturn(new APIResponseData($resourceResponseDatum));
        }

        /** @var ResourceAPIResponseDataFactory $responseDataFactory */
        $apiResponseData = $responseDataFactory->multipleToAPIResponseData($resources);

        $this->assertEquals($resourceResponseData, $apiResponseData->getData());
    }

    public function testMultipleToAPIResponseDataCallsToAPIResponseDataWithEachResourceWhen2Resources()
    {
        $resource = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Resource')->getMock();
        $resources = [
            $resource,
            $resource
        ];
        $resourceResponseData = [
            ["a"=>"B"],
            ["d"=>"g"]
        ];
        $responseDataFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceAPIResponseDataFactory')
            ->getMockForAbstractClass();

        foreach($resourceResponseData as $i => $resourceResponseDatum) {
            $responseDataFactory->expects($this->at($i))->method('toAPIResponseData')->with($resource)
                ->willReturn(new APIResponseData($resourceResponseDatum));
        }

        /** @var ResourceAPIResponseDataFactory $responseDataFactory */
        $apiResponseData = $responseDataFactory->multipleToAPIResponseData($resources);

        $this->assertEquals($resourceResponseData, $apiResponseData->getData());
    }
}
