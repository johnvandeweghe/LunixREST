<?php
namespace LunixREST\APIRequest\RequestData;

class JSONRequestDataTest extends \PHPUnit_Framework_TestCase
{
    public function testRawDataIsNotButchered()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';

        $requestData = new JSONRequestData($rawData);

        $this->assertEquals($rawData, $requestData->getRawData());
    }

    public function testInvalidDataThrowsException()
    {
        $rawData = 'fgd dfgh dsfhr sdrf hrfytj ';

        $this->expectException('\LunixREST\APIRequest\BodyParser\Exceptions\InvalidRequestDataException');
        new JSONRequestData($rawData);
    }

    public function testGetStringValue()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';
        $expectedData = [
            "key1" => "foo",
            "key2" => "bar",
            "arr" => [
                1,
                2
            ]
        ];

        $requestData = new JSONRequestData($rawData);

        $this->assertEquals($expectedData["key1"], $requestData->get("key1"));
    }

    public function testGetArrayValue()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';
        $expectedData = [
            "key1" => "foo",
            "key2" => "bar",
            "arr" => [
                1,
                2
            ]
        ];

        $requestData = new JSONRequestData($rawData);

        $this->assertEquals($expectedData["arr"], $requestData->get("arr"));
    }

    public function testHasStringValue()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';

        $requestData = new JSONRequestData($rawData);

        $this->assertTrue($requestData->has("key1"));
    }

    public function testHasArrayValue()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';

        $requestData = new JSONRequestData($rawData);

        $this->assertTrue($requestData->has("arr"));
    }

    public function testHasEmptyArrayValue()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2],"arr3":[]}';

        $requestData = new JSONRequestData($rawData);

        $this->assertTrue($requestData->has("arr3"));
    }

    public function testGetAll()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';
        $expectedData = [
            "key1" => "foo",
            "key2" => "bar",
            "arr" => [
                1,
                2
            ]
        ];

        $requestData = new JSONRequestData($rawData);

        $this->assertEquals($expectedData, $requestData->getAllAsAssociativeArray());
    }
}
