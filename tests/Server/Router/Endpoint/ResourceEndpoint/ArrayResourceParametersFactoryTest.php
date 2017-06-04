<?php
namespace LunixREST\Server\Router\Endpoint\ResourceEndpoint;

use PHPUnit\Framework\TestCase;

class ArrayResourceParametersFactoryTest extends TestCase
{
    public function testCreateResourceParametersThrowsExceptionOnNonArrayData()
    {
        $requestData = false;
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);

        $this->expectException('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateResourceParametersException');

        /** @var ResourceParametersFactory $paramsFactory */
        $paramsFactory->createResourceParameters($request);
    }

    public function testCreateResourceParametersCallsCreateResourceParametersFromArrayWithMergedData()
    {
        $requestData = ["b" => "c"];
        $queryData = ["a" => "b"];
        $element = "123";
        $expectedData = [
            "a" => "b",
            "b" => "c"
        ];
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);
        $request->method('getElement')->willReturn($element);

        $paramsFactory->expects($this->once())->method('createResourceParametersFromArray')->with($element, $expectedData);

        /** @var ResourceParametersFactory $paramsFactory */
        $paramsFactory->createResourceParameters($request);
    }

    public function testCreateResourceParametersCallsCreateResourceParametersFromArrayWithMergedDataWithOverlap()
    {
        $requestData = ["b" => "c"];
        $queryData = ["b" => "b"];
        $element = "123";
        $expectedData = [
            "b" => "c"
        ];
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);
        $request->method('getElement')->willReturn($element);

        $paramsFactory->expects($this->once())->method('createResourceParametersFromArray')->with($element, $expectedData);

        /** @var ResourceParametersFactory $paramsFactory */
        $paramsFactory->createResourceParameters($request);
    }

    public function testCreateResourceParametersCallsCreateResourceParametersFromArrayWithMergedDataWithNullRequestData()
    {
        $requestData = null;
        $queryData = ["b" => "b"];
        $element = "123";
        $expectedData = [
            "b" => "b"
        ];
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);
        $request->method('getElement')->willReturn($element);

        $paramsFactory->expects($this->once())->method('createResourceParametersFromArray')->with($element, $expectedData);

        /** @var ResourceParametersFactory $paramsFactory */
        $paramsFactory->createResourceParameters($request);
    }

    public function testCreateResourceParametersReturnsCreatedResourceParameters()
    {
        $requestData = null;
        $queryData = ["b" => "b"];
        $params = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParameters')->getMock();
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $paramsFactory->method('createResourceParametersFromArray')->willReturn($params);
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);

        /** @var ResourceParametersFactory $paramsFactory */
        $returnedParams = $paramsFactory->createResourceParameters($request);

        $this->assertSame($params, $returnedParams);
    }

    public function testCreateMultipleResourceParametersThrowsExceptionOnNonArrayData()
    {
        $requestData = false;
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);

        $this->expectException('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\Exceptions\UnableToCreateResourceParametersException');

        /** @var ResourceParametersFactory $paramsFactory */
        $paramsFactory->createMultipleResourceParameters($request);
    }

    public function testCreateMultipleResourceParametersCallsCreateResourceParametersFromArrayWithMergedData()
    {
        $requestData = [["b" => "c"]];
        $queryData = ["a" => "b"];
        $element = "123";
        $expectedData = [
            "a" => "b",
            "b" => "c"
        ];
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);
        $request->method('getElement')->willReturn($element);

        $paramsFactory->expects($this->once())->method('createResourceParametersFromArray')->with($element, $expectedData);

        /** @var ResourceParametersFactory $paramsFactory */
        $paramsFactory->createMultipleResourceParameters($request);
    }

    public function testCreateMultipleResourceParametersCallsCreateResourceParametersFromArrayWithMergedDataWithMultipleDatas()
    {
        $requestData = [["b" => "c"], ["d" => "e"]];
        $queryData = ["a" => "b"];
        $element = "123";
        $expectedData = [
            "a" => "b",
            "b" => "c"
        ];
        $expectedData2 = [
            "a" => "b",
            "d" => "e"
        ];
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);
        $request->method('getElement')->willReturn($element);

        $paramsFactory->expects($this->at(0))->method('createResourceParametersFromArray')
            ->with($element, $expectedData);
        $paramsFactory->expects($this->at(1))->method('createResourceParametersFromArray')
            ->with($element, $expectedData2);

        /** @var ResourceParametersFactory $paramsFactory */
        $paramsFactory->createMultipleResourceParameters($request);
    }

    public function testCreateMultipleResourceParametersCallsCreateResourceParametersFromArrayWithNullData()
    {
        $requestData = null;
        $queryData = ["a" => "b"];
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);

        /** @var ResourceParametersFactory $paramsFactory */
        $returnParams = $paramsFactory->createMultipleResourceParameters($request);

        $this->assertEmpty($returnParams);
    }

    public function testCreateMultipleResourceParametersCallsCreateResourceParametersFromArrayWithEmptyData()
    {
        $requestData = [];
        $queryData = ["a" => "b"];
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);

        /** @var ResourceParametersFactory $paramsFactory */
        $returnParams = $paramsFactory->createMultipleResourceParameters($request);

        $this->assertEmpty($returnParams);
    }

    public function testCreateMultipleResourceParametersReturnsArrayOfParamsOfSize1()
    {
        $requestData = [["b" => "c"]];
        $queryData = ["a" => "b"];
        $params = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParameters')->getMock();
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $paramsFactory->method('createResourceParametersFromArray')->willReturn($params);
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);

        /** @var ResourceParametersFactory $paramsFactory */
        $returnedParams = $paramsFactory->createMultipleResourceParameters($request);

        $this->assertEquals([$params], $returnedParams);
    }

    public function testCreateMultipleResourceParametersReturnsArrayOfParamsOfSize2()
    {
        $requestData = [["b" => "c"], ["d" => "e"]];
        $queryData = ["a" => "b"];
        $params = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ResourceParameters')->getMock();
        $paramsFactory = $this->getMockBuilder('\LunixREST\Server\Router\Endpoint\ResourceEndpoint\ArrayResourceParametersFactory')
            ->getMockForAbstractClass();
        $paramsFactory->method('createResourceParametersFromArray')->willReturn($params);
        $request = $this->getMockBuilder('\LunixREST\Server\APIRequest\APIRequest')
            ->disableOriginalConstructor()->getMock();
        $request->method('getData')->willReturn($requestData);
        $request->method('getQueryData')->willReturn($queryData);

        /** @var ResourceParametersFactory $paramsFactory */
        $returnedParams = $paramsFactory->createMultipleResourceParameters($request);

        $this->assertEquals([$params, $params], $returnedParams);
    }
}
