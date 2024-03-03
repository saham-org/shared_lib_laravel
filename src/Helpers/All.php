<?php

use Saham\SharedLibs\Models\Store;

if (!function_exists('getStoreServices')) {
    /**
     * @param Store $store,
     * @param bool  $default
     *
     * @return array<string, bool>
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
            'delivery'    => $store->services['delivery'] ?? false,
            'pickup'      => $store->services['pickup'] ?? false,
            'reservation' => $store->services['reservation'] ?? false,
            'feasts'      => $store->services['feasts'] ?? false,
        ];
    }
}

if (!function_exists('getStoreServicesFromNull')) {
    /**
     * @param bool $default
     *
     * @return array<string, bool>
     */
    function getStoreServicesFromNull($default = false): mixed
    {
        return [
            'delivery'    => $default,
            'pickup'      => $default,
            'reservation' => $default,
            'feasts'      => $default,
        ];
    }
}

///driver
if (!function_exists('getDriverServices')) {
    /**
     * @param Driver $driver,
     * @param bool   $default
     *
     * @return array<string, bool>
     */
    function getDriverServices(object $driver, $default = false): mixed
    {
        return isset($driver->services) ? getDriverServicesFromdriver($driver) : getDriverServicesFromNull($default);
    }
}

if (!function_exists('getDriverServicesFromdriver')) {
    function getDriverServicesFromdriver(object $driver): mixed
    {
        return [
            'package_order'     => $driver->services['package_order'] ?? false,
            'delivery_order'      => $driver->services['delivery_order'] ?? false,
            'feasts'            => $driver->services['feasts'] ?? false,
        ];
    }
}

if (!function_exists('getDriverServicesFromNull')) {
    /**
     * @param bool $default
     *
     * @return array<string, bool>
     */
    function getDriverServicesFromNull($default = false): mixed
    {
        return [
            'package_order'     => $default,
            'delivery_order'      => $default,
            'feasts'            => $default,
        ];
    }
}
//end driver

///user
if (!function_exists('getUserServices')) {
    /**
     * @param User $user,
     * @param bool $default
     *
     * @return array<string, bool>
     */
    function getUserServices(object $user, $default = false): mixed
    {
        return isset($user->services) ? getUserAcceptedServices($user) : getUserAcceptedServicesFromNull($default);
    }
}

if (!function_exists('getUserAcceptedServices')) {
    function getUserAcceptedServices(object $user): mixed
    {
        return [
            'package_order'     => $user->services['package_order'] ?? false,
            'delivery_order'      => $user->services['delivery_order'] ?? false,
            'reservations'      => $user->services['reservations'] ?? false,
            'feasts'            => $user->services['feasts'] ?? false,
        ];
    }
}

if (!function_exists('getUserAcceptedServicesFromNull')) {
    /**
     * @param bool $default
     *
     * @return array<string, bool>
     */
    function getUserAcceptedServicesFromNull($default = false): mixed
    {
        return [
            'package_order'     => $default,
            'delivery_order'      => $default,
            'reservations'      => $default,
            'feasts'            => $default,
        ];
    }
}
//end user

/**
 * Calculates the great-circle distance between two points, with
 * the Vincent formula.
 *
 * @param float $latitudeFrom  Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo    Latitude of target point in [deg decimal]
 * @param float $longitudeTo   Longitude of target point in [deg decimal]
 * @param float $earthRadius   Mean earth radius in [m]
 *
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
    $latTo   = deg2rad($latitudeTo);
    $lonTo   = deg2rad($longitudeTo);

    $lonDelta = $lonTo - $lonFrom;
    $a        = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);

    return $angle * $earthRadius;
}

/**
 * @param object $object
 * @param bool   $default
 *
 * @return array<string, bool>
 */
function getSystemPaymentMethods(array $object, $default = true): mixed
{
    return [
        'online'    => $object['online'] ?? $default,
        'wallet'    => $object['wallet'] ?? $default,
        'cash'      => $object['cash'] ?? $default,
    ];
}