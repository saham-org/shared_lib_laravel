<?php

namespace Saham\SharedLibs\Mongodb\Queue\Failed;

use Carbon\Carbon;
use Exception;
use Illuminate\Queue\Failed\DatabaseFailedJobProvider;

class MongoFailedJobProvider extends DatabaseFailedJobProvider
{
    /**
     * Log a failed job into storage.
     *
     * @param string     $connection
     * @param string     $queue
     * @param string     $payload
     * @param Exception $exception
     */
    public function log($connection, $queue, $payload, $exception): void
    {
        $failed_at = Carbon::now()->getTimestamp();

        $exception = (string) $exception;

        $this->getTable()->insert(compact('connection', 'queue', 'payload', 'failed_at', 'exception'));
    }

    /**
     * Get a list of all of the failed jobs.
     *
     * @return array<object>
     */
    public function all(): array
    {
        $all = $this->getTable()->orderBy('_id', 'desc')->get()->all();

        $all = array_map(static function ($job) {
            $job['id'] = (string) $job['_id'];

            return (object) $job;
        }, $all);

        return $all;
    }

    /**
     * Get a single failed job.
     *
     * @param mixed $id
     *
     */
    public function find($id): object
    {
        $job = $this->getTable()->find($id);

        if (!$job) {
            return;
        }

        $job['id'] = (string) $job['_id'];

        return (object) $job;
    }

    /**
     * Delete a single failed job from storage.
     *
     * @param mixed $id
     *
     */
    public function forget($id): bool
    {
        return $this->getTable()->where('_id', $id)->delete() > 0;
    }
}
