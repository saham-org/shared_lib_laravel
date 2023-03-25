<?php

namespace SahamLibs\Models;

use SahamLibs\Mongodb\Eloquent\Model;

class Activity extends Model
{
    protected $connection = 'mongodb_log';
    protected $table      = 'activity_log';
    protected $fillable   = ['event', 'related_id', 'related_type', 'guard_name', 'subject', 'causer', 'properties', 'old_properties', 'date'];
}
