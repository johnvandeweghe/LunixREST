<?php
namespace Sample\EndPoints;

class phonenumber extends \LunixREST\EndPoints\EndPoint {

    public function get($phoneNumber, $data){
		$phoneNumber = preg_replace('/[^0-9]/s', '', $phoneNumber);
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