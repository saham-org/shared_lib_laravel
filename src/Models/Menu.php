<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\HasOne;
use Saham\SharedLibs\Traits\Translatable;

class Menu extends BaseModel
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $translatable = ['title'];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'partner_id', 'partner_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function feastProducts(): HasMany
    {
        return $this->hasMany(FeastProduct::class);
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
