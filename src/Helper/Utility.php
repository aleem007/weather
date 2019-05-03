<?php

namespace App\Helper;

class Utility {

    public function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function findDirectionByDegree($degree)
    {
        $val = floor(($degree/22.5) + 0.5);
        $array = [
            "North",
            "North-North East",
            "North East",
            "East-North East",
            "East",
            "East-South East",
            "South East",
            "South-South East",
            "South",
            "South-South West",
            "South West",
            "West-South West",
            "West",
            "West-North West",
            "North West",
            "North-North West"
        ];
        return $array[($val % 16)];
    }
}