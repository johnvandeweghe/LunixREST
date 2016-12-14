<?php
namespace LunixREST\Request\RequestData;

use LunixREST\Request\BodyParser\Exceptions\InvalidRequestDataException;

class JSONRequestData implements RequestData {

    protected $jsonString;

    protected $parsedData = [];

    /**
     * JSONRequestData constructor.
     * @param $body
     * @throws InvalidRequestDataException
     */
    public function __construct($body) {
        $this->jsonString = $body;
        $this->parsedData = json_decode($body, true);
        if($this->parsedData === null) {
            throw new InvalidRequestDataException('Content not valid JSON');
        }
    }

    /**
     * Returns the raw data that the requestData tried to parse
     * @return string
     */
    public function getRawData(): string {
        return $this->jsonString;
    }

    /**
     * Attempts to get a specific key from the parsed data. Returns NULL if non-existent key (use has($key) if
     * there is a difference between a null value and a missing value)
     * WARNING: Parsed data is not sanitized, and should be treated as regular user data
     * @param string $key
     * @return mixed
     */
    public function get(string $key) {
        return $this->parsedData[$key] ?? null;
    }

    /**
     * Attempts to find a specific key in the parsed data. Returns true if found else false
     * @param string $key
     * @return mixed
     */
    public function has(string $key): bool {
        return isset($this->parsedData[$key]);
    }

    /**
     * Gets all parsed data as an associative array
     * WARNING: Parsed data is not sanitized, and should be treated as regular user data
     * @return array
     */
    public function getAllAsAssociativeArray(): array {
        return $this->parsedData;
    }
}
