<?php
namespace Sample\Endpoints\v1;

use LunixREST\Endpoints\Endpoint;

class phonenumbers extends Endpoint {

    public function get(){
		$phoneNumber = preg_replace('/[^0-9]/s', '', $this->request->getInstance());
		$areaCode = substr($phoneNumber, 0, 3);
		$nextThree = substr($phoneNumber, 3, 3);
		$file = fopen('data.csv', 'r');
		while (($data = fgetcsv($file)) !== FALSE) {
			if($areaCode == $data[0] && $nextThree == $data[1]){
				return ["location" =>
					[
						'city' => $data[2],
						'state' => $data[3]
					]
				];
			}
		}

		return [
			'location' => [
				'city' => '',
				'state' => ''
			]
		];
	}
}