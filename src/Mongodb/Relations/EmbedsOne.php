<?php

namespace Saham\SharedLibs\Mongodb\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use MongoDB\BSON\ObjectID;

class EmbedsOne extends EmbedsOneOrMany
{
    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, null);
        }

        return $models;
    }

    public function getResults()
    {
        return $this->toModel($this->getEmbedded());
    }

    public function getEager()
    {
        $eager = $this->get();

        // EmbedsOne only brings one result, Eager needs a collection!
        return $this->toCollection([$eager]);
    }

    /**
     * Save a new model and attach it to the parent model.
     *
     * @param Model $model
     *
     */
    public function performInsert(Model $model): Model|bool
    {
        // Generate a new key if needed.
        if ($model->getKeyName() === '_id' && !$model->getKey()) {
            $model->setAttribute('_id', new ObjectID());
        }

        // For deeply nested documents, let the parent handle the changes.
        if ($this->isNested()) {
            $this->associate($model);

            return $this->parent->save() ? $model : false;
        }

        $result = $this->getBaseQuery()->update([$this->localKey => $model->getAttributes()]);

        // Attach the model to its parent.
        if ($result) {
            $this->associate($model);
        }

        return $result ? $model : false;
    }

    /**
     * Save an existing model and attach it to the parent model.
     *
     * @param Model $model
     *
     */
    public function performUpdate(Model $model): Model|bool
    {
        if ($this->isNested()) {
            $this->associate($model);

            return $this->parent->save();
        }

        $values = $this->getUpdateValues($model->getDirty(), $this->localKey . '.');

        $result = $this->getBaseQuery()->update($values);

        // Attach the model to its parent.
        if ($result) {
            $this->associate($model);
        }

        return $result ? $model : false;
    }

    /**
     * Delete an existing model and detach it from the parent model.
     *
     */
    public function performDelete(): ?int
    {
        // For deeply nested documents, let the parent handle the changes.
        if ($this->isNested()) {
            $this->dissociate();

            return $this->parent->save();
        }

        // Overwrite the local key with an empty array.
        $result = $this->getBaseQuery()->update([$this->localKey => null]);

        // Detach the model from its parent.
        if ($result) {
            $this->dissociate();
        }

        return $result;
    }

    /**
     * Attach the model to its parent.
     *
     * @param Model $model
     *
     */
    public function associate(Model $model): ?Model
    {
        return $this->setEmbedded($model->getAttributes());
    }

    /**
     * Detach the model from its parent.
     *
     */
    public function dissociate(): ?Model
    {
        return $this->setEmbedded(null);
    }

    /**
     * Delete all embedded models.
     *
     */
    public function delete(): ?int
    {
        return $this->performDelete();
    }

    /**
     * Get the name of the "where in" method for eager loading.
     *
     * @param Model $model
     * @param string                              $key
     *
     */
    protected function whereInMethod(EloquentModel $model, $key): string
    {
        return 'whereIn';
    }
}
