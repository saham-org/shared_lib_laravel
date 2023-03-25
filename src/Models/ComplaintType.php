<?php

namespace SahamLibs\Models;

use SahamLibs\Models\Abstracts\BaseModel;
use SahamLibs\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComplaintType extends BaseModel
{
    use HasFactory;
    use Translatable;

    protected $translatable = ['name'];
    protected $fillable = ['name_ar', 'name_en', 'user_type'];
}
