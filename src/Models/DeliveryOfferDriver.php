<?php

namespace Saham\SharedLibs\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
class DeliveryOfferDriver Extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;
    protected $guarded = [];
    protected $table = 'delivery_offer_drivers';

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    public function deliveryOffer(): BelongsTo
    {
        return $this->belongsTo(DeliveryOffer::class, 'delivery_offer_id');
    }


}
