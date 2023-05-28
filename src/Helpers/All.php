<?php

use Saham\SharedLibs\Database\Factories\StoreFactory;
use Saham\SharedLibs\Models\Store;
use Saham\SharedLibs\Mongodb\Eloquent\Model;

if (!function_exists('getStoreServices')) {
    /**
     * @param Store $store,
     * @param bool $default
     * @return array<string, boolean>
     */
    function getStoreServices(object $store, $default = false): mixed
    {
        return isset($store->services) ? getStoreServicesFromStore($store) : getStoreServicesFromNull($default);
    }
}

if (!function_exists('getStoreServicesFromStore')) {
    function getStoreServicesFromStore(object $store): mixed
    {
        return [
            'delivery' => $store->services['delivery'] ?? false,
            'pickup' => $store->services['pickup'] ?? false,
            'reservation' => $store->services['reservation'] ?? false,
            'feasts' => $store->services['feasts'] ?? false,
        ];
    }
}

if (!function_exists('getStoreServicesFromNull')) {
    /**
     * @param bool $default
     * @return array<string, boolean>
     */
    function getStoreServicesFromNull($default = false): mixed
    {
        return [
            'delivery' => $default,
            'pickup' => $default,
            'reservation' => $default,
            'feasts' => $default,
        ];
    }
}

/**
 * Calculates the great-circle distance between two points, with
 * the Vincent formula.
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
): float {
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


/**
 * @param object $object
 * @param bool $default
 * @return array<string, boolean>
 */
function getSystemPaymentMethods(object $object, $default = true): mixed
{
    return isset($object->allowed_payment_types) ? getSystemPaymentMethodsFromObject($object, $default) : getSystemPaymentMethodsFromNull($default);
}
/**
 * @param object $object
 * @param boolean $default
 * @return array<string, boolean>
 */
function getSystemPaymentMethodsFromObject(object $object, bool $default = true): mixed
{
    return [
        'online'    => $object->allowed_payment_types['online'] ?? $default,
        'wallet'    => $object->allowed_payment_types['wallet'] ?? $default,
        'cash'      => $object->allowed_payment_types['cash'] ?? $default,
    ];
}

/**
 * @param boolean $default
 * @return array<string, boolean>
 */
function getSystemPaymentMethodsFromNull($default = true): mixed
{
    return [
        'online'    => $default,
        'wallet'    => $default,
        'cash'      => $default,
    ];
}
