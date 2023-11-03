<?php

namespace Saham\SharedLibs\Mongodb\Relations;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\MorphMany as EloquentMorphMany;

class MorphMany extends EloquentMorphMany
{
    /**
     * Get the name of the "where in" method for eager loading.
     *
     * @param EloquentModel $model
     * @param string                              $key
     *
     */
    protected function whereInMethod(EloquentModel $model, $key): string
    {
        return 'whereIn';
    }
}
