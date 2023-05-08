<?php

namespace Saham\SharedLibs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feast extends Order
{
    use HasFactory;

    protected $table = 'feasts';
}
