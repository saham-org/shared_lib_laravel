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

class DriverReward Extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;
    protected $guarded = [];
    protected $table = 'deliver_rewards';

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }


}
