<?php

namespace Saham\SharedLibs\Models\Enums;

enum ComplainStatus: string
{
    case Pending = 'pending';

    case Rejected = 'rejected';

    case Opened = 'opened';

    case Closed = 'closed';

    case Support = 'support';

    case Solved = 'solved';

    /**
     * Get all statues statuses.
     *
     * @return array<string>
     */
    public static function toArray(): array
    {
        return array_column(ComplainStatus::cases(), 'value');
    }

    /**
     * Get all complain change to status statuses.
     *
     * @return array<string>
     */
    public static function onlyComplainStatus(): array
    {
        return array_column(([
            self::Pending,
            self::Opened,
            self::Closed,
            self::Support,
            self::Solved,
        ]), 'value');
    }
}
