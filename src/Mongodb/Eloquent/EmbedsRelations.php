<?php

namespace Saham\SharedLibs\Mongodb\Eloquent;

use Illuminate\Support\Str;
use Saham\SharedLibs\Mongodb\Relations\EmbedsMany;
use Saham\SharedLibs\Mongodb\Relations\EmbedsOne;

trait EmbedsRelations
{
    /**
     * Define an embedded one-to-many relationship.
     *
     * @param string $related
     * @param string $localKey
     * @param string $foreignKey
     * @param string $relation
     *
     */
    protected function embedsMany(
        $related,
        $localKey = null,
        $foreignKey = null,
        $relation = null
    ): EmbedsMany {
        // If no relation name was given, we will use this debug backtrace to extract
        // the calling method's name and use that as the relationship name as most
        // of the time this will be what we desire to use for the relationships.
        if ($relation === null) {
            [, $caller] = debug_backtrace(false);

            $relation = $caller['function'];
        }

        if ($localKey === null) {
            $localKey = $relation;
        }

        if ($foreignKey === null) {
            $foreignKey = Str::snake(class_basename($this));
        }

        $query = $this->newQuery();

        $instance = new $related();

        return new EmbedsMany($query, $this, $instance, $localKey, $foreignKey, $relation);
    }

    /**
     * Define an embedded one-to-many relationship.
     *
     * @param string $related
     * @param string $localKey
     * @param string $foreignKey
     * @param string $relation
     *
     */
    protected function embedsOne(
        $related,
        $localKey = null,
        $foreignKey = null,
        $relation = null
    ): EmbedsOne {
        // If no relation name was given, we will use this debug backtrace to extract
        // the calling method's name and use that as the relationship name as most
        // of the time this will be what we desire to use for the relationships.
        if ($relation === null) {
            [, $caller] = debug_backtrace(false);

            $relation = $caller['function'];
        }

        if ($localKey === null) {
            $localKey = $relation;
        }

        if ($foreignKey === null) {
            $foreignKey = Str::snake(class_basename($this));
        }

        $query = $this->newQuery();

        $instance = new $related();

        return new EmbedsOne($query, $this, $instance, $localKey, $foreignKey, $relation);
    }
}
