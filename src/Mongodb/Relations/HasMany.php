<?php

namespace Saham\SharedLibs\Mongodb\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany as EloquentHasMany;

class HasMany extends EloquentHasMany
{
    /**
     * Get the plain foreign key.
     *
     */
    public function getForeignKeyName(): ?string
    {
        return $this->foreignKey;
    }

    /**
     * Get the key for comparing against the parent key in "has" query.
     *
     */
    public function getHasCompareKey(): ?string
    {
        return $this->getForeignKeyName();
    }

    /**
     * @inheritdoc
     */
    public function getRelationExistenceQuery(Builder $query, Builder $parentQuery, $columns = ['*'])
    {
        $foreignKey = $this->getHasCompareKey();

        return $query->select($foreignKey)->where($foreignKey, 'exists', true);
    }

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
