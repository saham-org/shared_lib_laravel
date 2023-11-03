<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Database\Factories\FeastFactory;
 use Saham\SharedLibs\Mongodb\Relations\BelongsTo;
use Saham\SharedLibs\Mongodb\Relations\HasMany;

class Feast extends Order
{
    use HasFactory;

    protected $table = 'feasts';

    protected static function newFactory(): mixed
    {
        return FeastFactory::new();
    }

    public function details(): HasMany
    {
        return $this->hasMany(FeastDetails::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
