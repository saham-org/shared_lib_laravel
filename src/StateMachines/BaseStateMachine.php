<?php

namespace Saham\SharedLibs\StateMachines;

use Ashraf\EloquentStateMachine\StateMachines\StateMachine;
use Illuminate\Contracts\Auth\Authenticatable;
use Saham\SharedLibs\Models\Abstracts\BaseModel;

abstract class BaseStateMachine extends StateMachine
{
    /**
     * Check if the given group is in the group of the given user
     * @param array $group
     * @param BaseModel $who
     */
    public function inGroup(array $group, string|Authenticatable $who = 'system'): bool
    {
        return $who === null || $who === 'system' || in_array($who->getTable(), $group, true);
    }
}
