<?php

namespace Saham\SharedLibs\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\UTCDateTime;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Relations\HasMany;
use Saham\SharedLibs\Traits\Translatable;

class Reward extends BaseModel
{
    use HasFactory;
    use SoftDeletes ;
    use Translatable;
    protected $guarded = [];
    protected $table = 'rewards';
    protected $translatable = ['name'] ;


    public function userReward(): HasMany
    {
        return $this->hasMany(UserReward::class);
    }
    public function driverReward(): HasMany
    {
        return $this->hasMany(DriverReward::class);
    }


}
