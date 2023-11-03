<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Saham\SharedLibs\Models\Abstracts\BaseModel;

class Favorite extends BaseModel
{
    use HasFactory;

    public $timestamps      = false;

    public function store(): mixed
    {
        return $this->belongsTo(Store::class);
    }

    public function user(): mixed
    {
        return $this->belongsTo(User::class);
    }
}
