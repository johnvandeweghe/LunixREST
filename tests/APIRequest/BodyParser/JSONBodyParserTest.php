<?php
namespace LunixREST\APIRequest\BodyParser;

class JSONBodyParserTest extends \PHPUnit_Framework_TestCase
{
    public function testRawDataIsNotButchered()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';

        $parser = new JSONBodyParser();
        $requestData = $parser->parse($rawData);

        $this->assertEquals($rawData, $requestData->getRawData());
    }

    public function testInvalidDataThrowsException()
    {
        $rawData = 'fgd dfgh dsfhr sdrf hrfytj ';

        $this->expectException('\LunixREST\Request\BodyParser\Exceptions\InvalidRequestDataException');
        $parser = new JSONBodyParser();
        $parser->parse($rawData);
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

        $parser = new JSONBodyParser();
        $requestData = $parser->parse($rawData);

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

        $parser = new JSONBodyParser();
        $requestData = $parser->parse($rawData);

        $this->assertEquals($expectedData["arr"], $requestData->get("arr"));
    }

    public function testHasStringValue()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';

        $parser = new JSONBodyParser();
        $requestData = $parser->parse($rawData);

        $this->assertTrue($requestData->has("key1"));
    }

    public function testHasArrayValue()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2]}';

        $parser = new JSONBodyParser();
        $requestData = $parser->parse($rawData);

        $this->assertTrue($requestData->has("arr"));
    }

    public function testHasEmptyArrayValue()
    {
        $rawData = '{"key1":"foo","key2":"bar","arr":[1,2],"arr3":[]}';

        $parser = new JSONBodyParser();
        $requestData = $parser->parse($rawData);

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

        $parser = new JSONBodyParser();
        $requestData = $parser->parse($rawData);

        $this->assertEquals($expectedData, $requestData->getAllAsAssociativeArray());
    }
}
