<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Traits\HasRating ;

class Rating extends BaseModel
{
    use HasFactory;
    use HasRating;
    protected $table              = 'ratings';
    protected $fillable           = ['order_id', 'related_id', 'related_type', 'store_id', 'user_id', 'rating', 'description', ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }



}
