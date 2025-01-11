<?php

namespace Saham\SharedLibs\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Mongodb\Laravel\Eloquent\SoftDeletes;
use Mongodb\Laravel\Relations\BelongsTo;
use Mongodb\Laravel\Relations\HasMany;

class UserReward  Extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'user_rewards';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }


}
