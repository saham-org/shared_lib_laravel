<?php

namespace Saham\SharedLibs\StateMachines;

use Saham\SharedLibs\Models\Enums\OrderStatus;

class OrderStatusMachine extends BaseStateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function defaultState(): ?string
    {
        return OrderStatus::Pending->value;
    }


    public function transitions(): array
    {
        return [
            // from => to pattern
            '*' => [
                OrderStatus::Pending->value => fn($model, $who) => true,
            ],

            // handle pending trasitions
            OrderStatus::Pending->value => [
                OrderStatus::Expired->value => fn($model, $who) => $this->inGroup([], $who),
                OrderStatus::Rejected->value => fn($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
                OrderStatus::Accepted->value => fn($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
                OrderStatus::Assigned->value => fn($model, $who) => $this->inGroup(['administrators', 'drivers', 'opertional'], $who) && $model->deliver_type == 'delivery',
                OrderStatus::Cancelled->value => fn($model, $who) => $this->inGroup(['user', 'administrators'], $who),
            ],

            // handle assigned trasitions
            OrderStatus::Assigned->value => [
                OrderStatus::Accepted->value => fn($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who) && $model->deliver_type == 'delivery',
                OrderStatus::Rejected->value => fn($model, $who) => $this->inGroup(['user', 'administrators'], $who),
                OrderStatus::Cancelled->value => fn($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
                OrderStatus::Preparing->value => fn($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
            ],

            // handle accepted trasitions
            OrderStatus::Accepted->value => [
                OrderStatus::Rejected->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
                OrderStatus::Accepted->value => fn($model, $who) => $this->inGroup(['administrators', 'opertional'], $who) && $model->deliver_type == 'delivery',
                OrderStatus::Preparing->value => fn($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
            ],

            // handle preparing trasitions
            OrderStatus::Preparing->value => [
                OrderStatus::Accepted->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
                OrderStatus::Rejected->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
                OrderStatus::Prepared->value => fn($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
            ],

            // handle prepared trasitions
            OrderStatus::Prepared->value => [
                OrderStatus::Prepared->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
                OrderStatus::Accepted->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
                OrderStatus::Rejected->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
                OrderStatus::Completed->value => fn($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who) && $model->deliver_type == 'receipt',
                OrderStatus::InDelivery->value => fn($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type == 'delivery',
            ],

            // handle in delivery trasitions
            OrderStatus::InDelivery->value => [
                OrderStatus::InLocation->value => fn($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type == 'delivery',
                OrderStatus::Prepared->value => fn($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type == 'delivery',
                OrderStatus::Preparing->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
                OrderStatus::Rejected->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
            ],

            // handle in location trasitions
            OrderStatus::InLocation->value => [
                OrderStatus::Completed->value => fn($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type == 'delivery',
                OrderStatus::InDelivery->value => fn($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type == 'delivery',
                OrderStatus::Rejected->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
            ],

            // handle rejected trasitions
            OrderStatus::Rejected->value => [
                OrderStatus::Cancelled->value => fn($model, $who) => $this->inGroup([], $who),
                OrderStatus::Pending->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
                OrderStatus::Accepted->value => fn($model, $who) => $this->inGroup(['administrators'], $who),
            ],

            // handle expired trasitions
            OrderStatus::Expired->value => [
                OrderStatus::Cancelled->value => fn($model, $who) => $this->inGroup([], $who),
                OrderStatus::Pending->value => fn($model, $who) => $this->inGroup(['administrators', 'user'], $who),
            ],

            // handle cancelled trasitions
            OrderStatus::Cancelled->value => [
                OrderStatus::Refunded->value => fn($model, $who) => $this->inGroup([], $who),
            ],

            // handle refunded trasitions
            OrderStatus::Refunded->value => [],

            // handle completed trasitions
            OrderStatus::Completed->value => [],

        ];
    }
}
