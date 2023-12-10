<?php

namespace Saham\SharedLibs\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\HasMany;
class DriverDeliveryOffer Extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;
    protected $guarded = [];
    protected $table = 'deliver_delivery_offers';

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    public function deliveryOffer(): BelongsTo
    {
        return $this->belongsTo(DeliveryOffer::class, 'delivery_offer_id');
    }


}