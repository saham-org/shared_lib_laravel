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
            'delivery' => $store->services['delivery'],
            'pickup' => $store->services['pickup'],
            'reservation' => $store->services['reservation'],
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
        ];
    }
}
