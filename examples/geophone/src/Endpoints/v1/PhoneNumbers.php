<?php
namespace GeoPhone\Endpoints\v1;

use GeoPhone\Models\GeoPhone;
use LunixREST\Endpoint\DefaultEndpoint;
use LunixREST\Request\Request;
use LunixREST\Response\ResponseData;

class PhoneNumbers extends DefaultEndpoint
{

    protected $geoPhone;

    /**
     * PhoneNumbers constructor.
     * @param GeoPhone $geoPhone
     */
    public function __construct(GeoPhone $geoPhone)
    {
        $this->geoPhone = $geoPhone;
    }


    public function get(Request $request): ResponseData
    {
        return $this->geoPhone->lookupNumber($request->getInstance());
    }
}
