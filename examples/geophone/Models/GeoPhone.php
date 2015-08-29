<?php
namespace GeoPhone\Models;

/**
 * Class GeoPhone
 * @package GeoPhone\Models
 */
class GeoPhone {
    /**
     * @var resource
     */
    protected $fileHandle;

    /**
     * @param string $filename
     */
    public function __construct($filename = 'data.csv'){
        $this->fileHandle = fopen($filename, 'r');
    }

    /**
     * @param String $phoneNumber A phone number in any format
     * @return array an array with one value keyed with "location". The value is an array with two keys "city" and "state".
     * City and state are empty when not found.
     */
    public function lookupNumber($phoneNumber){
        $phoneNumber = preg_replace('/[^0-9]/s', '', $phoneNumber);
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);

        while (($data = fgetcsv($this->fileHandle)) !== FALSE) {
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