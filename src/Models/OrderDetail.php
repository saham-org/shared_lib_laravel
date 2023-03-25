<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Mongodb\Relations\BelongsTo;
use SahamLibs\Mongodb\Relations\EmbedsMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
