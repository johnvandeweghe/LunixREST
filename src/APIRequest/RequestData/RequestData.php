<?php
namespace LunixREST\APIRequest\RequestData;

interface RequestData
{
    /**
     * Returns the raw data that the requestData tried to parse
     * @return string
     */
    public function getRawData(): string;

    /**
     * Attempts to get a specific key from the parsed data. Returns NULL if non-existant key (use has($key) if
     * there is a difference between a null value and a missing value)
     * WARNING: Parsed data is not sanitized, and should be treated as regular user data
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * Attempts to find a specific key in the parsed data. Returns true if found else false
     * @param string $key
     * @return mixed
     */
    public function has(string $key): bool;

    /**
     * Gets all parsed data as an associative array
     * WARNING: Parsed data is not sanitized, and should be treated as regular user data
     * @return array
     */
    public function getAllAsAssociativeArray(): array;
}
