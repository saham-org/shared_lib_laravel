<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Saham\SharedLibs\Mongodb\Eloquent\SoftDeletes;
use Saham\SharedLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes ;

    protected $fillable = [
        'number', 'adult_min', 'adult_max', 'child_min', 'child_max', 'adult_price', 'child_price', 'imgs'
    ];

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
