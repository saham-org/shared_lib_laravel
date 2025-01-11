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

class Wallet  Extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'wallets';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

  


}
