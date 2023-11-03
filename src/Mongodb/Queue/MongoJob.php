<?php

namespace Saham\SharedLibs\Mongodb\Queue;

use DateTime;
use Illuminate\Queue\Jobs\DatabaseJob;

class MongoJob extends DatabaseJob
{
    /**
     * Indicates if the job has been reserved.
     *
     */
    public function isReserved(): bool
    {
        return $this->job->reserved;
    }

    public function reservedAt(): DateTime
    {
        return $this->job->reserved_at;
    }
}
