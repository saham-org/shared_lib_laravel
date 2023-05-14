<?php


if (!function_exists('getStoreServices')) {
    function getStoreServices($store, $default = false): mixed
    {
        return isset($store->services) ? getStoreServicesFromStore($store) : getStoreServicesFromNull($default);
    }
}


if (!function_exists('getStoreServicesFromStore')) {
    function getStoreServicesFromStore($store): mixed
    {
        return [
            'delivery' => $store->services['delivery'] ?? false ,
            'pickup' => $store->services['pickup'] ?? false ,
            'reservation' => $store->services['reservation'] ?? false ,
            'feasts' => $store->services['feasts'] ?? false ,
        ];
    }
}

if (!function_exists('getStoreServicesFromNull')) {
    function getStoreServicesFromNull($default = false): mixed
    {
        return [
            'delivery' => $default,
            'pickup' => $default,
            'reservation' => $default,
            'feasts' => $default ,
        ];
    }
}




if (!function_exists('getDistanceInMeter')) {
    /**
    * Calculates the great-circle distance between two points, with
    * the Vincenty formula.
    * @param float $latitudeFrom Latitude of start point in [deg decimal]
    * @param float $longitudeFrom Longitude of start point in [deg decimal]
    * @param float $latitudeTo Latitude of target point in [deg decimal]
    * @param float $longitudeTo Longitude of target point in [deg decimal]
    * @param float $earthRadius Mean earth radius in [m]
    * @return float Distance between points in [m] (same as earthRadius)
    */
    function getDistanceInMeter(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371000
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
          pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }
}
