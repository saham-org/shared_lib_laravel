<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Mongodb\Laravel\Relations\BelongsTo;
use Mongodb\Laravel\Relations\EmbedsMany;

class OrderDetail extends BaseModel
{
    use HasFactory;

    protected $with    = ['product'];
    public $timestamps = false;

    public function variations(): EmbedsMany
    {
        return $this->embedsMany(ProductVariation::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // public function feastProduct(): BelongsTo
    // {
    //     return $this->belongsTo(FeastProduct::class);
    // }
}
