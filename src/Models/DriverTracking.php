<?php

namespace Saham\SharedLibs\Models;

use DateTime;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;

class DriverTracking extends BaseModel
{
    private $maxLogRetentionDays = 30;

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public static function onNewLocation(string $driverId, array $location): void
    {
        $driver = Driver::find($driverId);
        if (is_null($driver)) {
            return;
        }

        /** only log 10m+ distances so we don't over populate the location log */
        if (
            getDistanceInMeter(
                $location['coordinates'][0],
                $location['coordinates'][1],
                $driver->location['coordinates'][0],
                $driver->location['coordinates'][1]
            ) > 10
        ) {
            self::logTracking($driver, $location);
        }

        $driver->updateQuietly(['location' => $location]);
    }

    public static function logTracking(Driver $driver, array $location): void
    {
        $hasTracking = self::where('driver_id', $driver->id)->first();
        $time_now = new UTCDateTime(new DateTime('now'));

        if ($hasTracking) {
            $hasTracking->push('logs', [
                'location' => $location,
                'created_at' => $time_now,
            ], false);
        } else {
            self::create([
                'driver_id' => $driver->id,
                'logs' => [
                    [
                        'location' => $location,
                        'order_id' => $driver->activeOrder()->first()->id ?? null,
                        'created_at' => $time_now,
                    ],
                ],
            ]);
        }

        self::deleteOldLogs($driver->id);
    }

    public static function deleteOldLogs(string $driverId): void
    {
        $time_30_days_ago = new UTCDateTime(new DateTime('-30 days'));

        $driverTrackings = self::where('logs.created_at', '<', $time_30_days_ago)->where('driver_id', $driverId)->get();

        foreach ($driverTrackings as $driverTracking) {
            $driverTracking->pull('logs', [
                'created_at' => [
                    '$lt' => $time_30_days_ago,
                ],
            ]);
            $driverTracking->save();
        }
    }
}
