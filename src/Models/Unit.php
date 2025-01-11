<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Mongodb\Laravel\Eloquent\SoftDeletes;
use Mongodb\Laravel\Relations\HasMany;
use Saham\SharedLibs\Traits\Translatable;

class Unit extends BaseModel
{
    use Translatable;
    use SoftDeletes ;

    protected $fillable = [
        'number', 'adult_min', 'adult_max', 'child_min', 'child_max', 'adult_price', 'child_price', 'imgs', 'store_id',
    ];

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
