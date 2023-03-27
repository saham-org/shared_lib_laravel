<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\DatabaseNotificationCollection;

class DatabaseNotification extends BaseModel
{
    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data'    => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Get the notifiable entity that the notification belongs to.
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): void
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread(): void
    {
        if (!is_null($this->read_at)) {
            $this->forceFill(['read_at' => null])->save();
        }
    }

    /**
     * Determine if a notification has been read.
     */
    public function read(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Determine if a notification has not been read.
     */
    public function unread(): bool
    {
        return $this->read_at === null;
    }

    /**
     * Scope a query to only include read notifications.
     *
     * @param Builder $query
     */
    public function scopeRead(Builder $query): Builder
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope a query to only include unread notifications.
     *
     * @param Builder $query
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    /**
     * Create a new database notification collection instance.
     *
     * @param array $models
     */
    public function newCollection(array $models = []): DatabaseNotificationCollection
    {
        return new DatabaseNotificationCollection($models);
    }
}
