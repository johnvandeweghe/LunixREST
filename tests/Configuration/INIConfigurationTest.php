<?php
namespace LunixREST\Configuration;

function parse_ini_file ($filename, $process_sections = null, $scanner_mode = null) {
    INIConfigurationTest::$parse_ini_call_arguments[] = [$filename, $process_sections, $scanner_mode];
    return INIConfigurationTest::$parse_ini_response;
}

class INIConfigurationTest extends \PHPUnit\Framework\TestCase
{
    //What to return in our mocked namespace function above
    public static $parse_ini_response = false;

    //Call log of the mocked function above
    public static $parse_ini_call_arguments = [];

    public function setUp() {
        self::$parse_ini_response = false;
        self:: $parse_ini_call_arguments = [];
    }

    public function testThrowsIniParseExceptionWithFalseParse() {
        self::$parse_ini_response = false;
        $this->expectException('\LunixREST\Configuration\Exceptions\INIParseException');

        new INIConfiguration('anything');
    }

    public function testCallsParseWithPassedFileAndProcessSections() {
        self::$parse_ini_response = [];
        $filename = "super_cool.ini";
        $expectedCall = [$filename, true, null];

        new INIConfiguration($filename);

        $this->assertContains($expectedCall, self::$parse_ini_call_arguments);
    }

    public function testHasReturnsTrueWhenEntryExists() {
        $namespace = 'the_namespace';
        $key = 'test';
        self::$parse_ini_response = [
                $namespace => [
                    $key => true
                ]
        ];
        $filename = "super_cool.ini";

        $configuration = new INIConfiguration($filename);
        $hasKey = $configuration->has($key, $namespace);

        $this->assertTrue($hasKey);
    }

    public function testHasReturnsFalseWhenNamespaceButNotEntryExists() {
        $namespace = 'the_namespace';
        $key = 'test';
        self::$parse_ini_response = [
            $namespace => [
                $key => true
            ]
        ];
        $filename = "super_cool.ini";

        $configuration = new INIConfiguration($filename);
        $hasKey = $configuration->has('Not $key', $namespace);

        $this->assertFalse($hasKey);
    }

    public function testHasReturnsFalseWhenNeitherNamespaceIrEntryExist() {
        $namespace = 'the_namespace';
        $key = 'test';
        self::$parse_ini_response = [
            $namespace => [
                $key => true
            ]
        ];
        $filename = "super_cool.ini";

        $configuration = new INIConfiguration($filename);
        $hasKey = $configuration->has('Not $key', 'Not $namespace');

        $this->assertFalse($hasKey);
    }

    public function testGetReturnsValueWhenEntryExists() {
        $namespace = 'the_namespace';
        $key = 'test';
        $expectedValue = "test value";
        self::$parse_ini_response = [
            $namespace => [
                $key => $expectedValue
            ]
        ];
        $filename = "super_cool.ini";

        $configuration = new INIConfiguration($filename);
        $value = $configuration->get($key, $namespace);

        $this->assertEquals($expectedValue, $value);
    }

    public function testGetReturnsNullWhenNamespaceButNotEntryExists() {
        $namespace = 'the_namespace';
        $key = 'test';
        self::$parse_ini_response = [
            $namespace => [
                $key => true
            ]
        ];
        $filename = "super_cool.ini";

        $configuration = new INIConfiguration($filename);
        $hasKey = $configuration->get('Not $key', $namespace);

        $this->assertNull($hasKey);
    }

    public function testGetReturnsNullWhenNeitherNamespaceIrEntryExist() {
        $namespace = 'the_namespace';
        $key = 'test';
        self::$parse_ini_response = [
            $namespace => [
                $key => true
            ]
        ];
        $filename = "super_cool.ini";

        $configuration = new INIConfiguration($filename);
        $hasKey = $configuration->get('Not $key', 'Not $namespace');

        $this->assertNull($hasKey);
    }
}
