<?php
namespace GeoPhone\Models;

/**
 * Class GeoPhone
 * @package GeoPhone\Models
 */
class GeoPhone
{
    /**
     * @var resource
     */
    protected $fileHandle;

    /**
     * @param string $filename
     */
    public function __construct($filename = 'data.csv')
    {
        $this->fileHandle = fopen($filename, 'r');
    }

    /**
     * @param String $phoneNumber A phone number in any format
     * @return LookupResponse
     * City and state are empty when not found.
     */
    public function lookupNumber($phoneNumber): LookupResponse
    {
        $phoneNumber = preg_replace('/[^0-9]/s', '', $phoneNumber);
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);

        while (($data = fgetcsv($this->fileHandle)) !== false) {
            if ($areaCode == $data[0] && $nextThree == $data[1]) {
                return new LookupResponse($data[2], $data[3]);
            }
        }

        return new LookupResponse('', '');
    }
}
