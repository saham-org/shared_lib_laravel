<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use MongoDB\BSON\UTCDateTime;
use DateTime;

class DriverTracking extends BaseModel
{
    private $maxLogRetentionDays = 30;
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }


    public static function onNewLocation(string $driverId, array $location)
    {
        $driver = Driver::find($driverId);
        $driver->location = $location;
        $driver->save();

        self::logTracking($driverId, $location);
    }


    public static function logTracking(string $driverId, array $location)
    {
        $hasTracking = self::where('driver_id', $driverId)->first();
        $time_now = new UTCDateTime(new DateTime('now'));

        if ($hasTracking) {
            $hasTracking->push('logs', [
                'location' => $location,
                'created_at' => $time_now
            ], false);
        } else {
            self::create([
                'driver_id' => $driverId,
                'logs' => [
                    [
                        'location' => $location,
                        'created_at' => $time_now
                    ]
                ]
            ]);
        }

        self::deleteOldLogs($driverId);
    }

    public static function deleteOldLogs(string $driverId)
    {
        $time_now = new UTCDateTime(new DateTime('now'));
        $time_30_days_ago = new UTCDateTime(new DateTime('-30 days'));

        $driverTrackings = self::where('logs.created_at', '<', $time_30_days_ago)->where('driver_id', $driverId)->get();

        foreach ($driverTrackings as $driverTracking) {
            $driverTracking->pull('logs', [
                'created_at' => [
                    '$lt' => $time_30_days_ago
                ]
            ]);
            $driverTracking->save();
        }
    }
}
