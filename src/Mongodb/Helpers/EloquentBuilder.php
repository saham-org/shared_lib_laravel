<?php

namespace Saham\SharedLibs\Mongodb\Helpers;

use Illuminate\Database\Eloquent\Builder;

class EloquentBuilder extends Builder
{
    use QueriesRelationships;
}
