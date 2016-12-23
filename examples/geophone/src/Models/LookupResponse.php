<?php
namespace GeoPhone\Models;

use LunixREST\APIResponse\ResponseData;

/**
 * Class GeoPhone
 * @package GeoPhone\Models
 */
class LookupResponse implements ResponseData
{
    protected $city;
    protected $state;

    /**
     * LookupResponse constructor.
     * @param string $city
     * @param string $state
     */
    public function __construct(string $city, string $state)
    {
        $this->city = $city;
        $this->state = $state;
    }


    /**
     * @return array
     */
    public function getAsAssociativeArray(): array
    {
        return [
            "location" => [
                'city' => $this->city,
                'state' => $this->state
            ]
        ];
    }
}
