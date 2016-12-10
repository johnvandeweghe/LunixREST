<?php
namespace GeoPhone\Endpoints\v1;

use LunixREST\Endpoints\Endpoint;
use GeoPhone\Models\GeoPhone;

class phonenumbers extends Endpoint {

    public function get(){
		$geoPhone = new GeoPhone('data.csv');
		return $geoPhone->lookupNumber($this->request->getInstance());
	}
}