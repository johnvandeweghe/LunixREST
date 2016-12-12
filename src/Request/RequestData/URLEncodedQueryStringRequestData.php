<?php
namespace LunixREST\Request\RequestData;

class URLEncodedQueryStringRequestData implements RequestData {

    protected $queryString;

    protected $parsedData = [];

    public function __construct($queryString) {
        $this->queryString = $queryString;
        parse_str($queryString, $this->parsedData);
    }

    /**
     * Returns the raw data that the requestData tried to parse
     * @return string
     */
    public function getRawData(): string {
        return $this->queryString;
    }

    /**
     * Attempts to get a specific key from the parsed data. Returns NULL if non-existant key (use has($key) if
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
