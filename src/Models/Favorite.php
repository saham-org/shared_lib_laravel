<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
