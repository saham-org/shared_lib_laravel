<?php

namespace Saham\SharedLibs\StateMachines;

use Saham\SharedLibs\Models\Enums\OrderStatus;

class OrderStatusMachine extends BaseStateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    /**
     * set default status of newly created models.
     */
    public function defaultState(): ?string
    {
        return OrderStatus::Pending->value;
    }

    /**
     * define list of available transitions.
     *
     * @return array<string,array<string,callable>>
     */
    public function transitions(): array
    {
        if (isset($this->model->order_type) && $this->model->order_type === 'package_order') {
            return [

                // handle pending transitions
                OrderStatus::Pending->value => [

                    OrderStatus::Accepted->value => fn ($model, $who) => $this->inGroup(['drivers', 'administrators'], $who),
                    OrderStatus::Rejected->value => fn ($model, $who) => $this->inGroup([  'administrators'], $who),

                    OrderStatus::Expired->value   => fn ($model, $who) => $this->inGroup([], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', 'administrators'], $who),
                ],

                // handle Accepted transitions
                OrderStatus::Accepted->value => [
                    OrderStatus::InLocation->value => fn ($model, $who) => $this->inGroup(['drivers', 'administrators'], $who),
                    OrderStatus::Rejected->value => fn ($model, $who) => $this->inGroup([  'administrators'], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', ], $who)


                ],
                // handle InLocation transitions
                OrderStatus::InLocation->value => [
                    OrderStatus::PriceReview->value => fn ($model, $who) => $this->inGroup(['drivers', 'administrators'], $who),
                    OrderStatus::Rejected->value => fn ($model, $who) => $this->inGroup([  'administrators'], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', ], $who)
                ],

                  // handle InLocation transitions
                  OrderStatus::PriceReview->value => [
                    OrderStatus::Paid->value => fn ($model, $who) => $this->inGroup([ 'users', 'administrators'], $who) ,
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', 'administrators'], $who)

                ],
                OrderStatus::Paid->value => [
                    OrderStatus::InDelivery->value => fn ($model, $who) => $this->inGroup(['drivers', 'administrators'], $who) ,
                    OrderStatus::Rejected->value => fn ($model, $who) => $this->inGroup([  'administrators'], $who),

                ],
                OrderStatus::InDelivery->value => [
                    OrderStatus::Completed->value => fn ($model, $who) => $this->inGroup(['drivers', 'administrators'], $who) ,
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', 'administrators'], $who)

                ],
                // handle rejected transitions
                OrderStatus::Rejected->value => [
                    OrderStatus::Pending->value   => fn ($model, $who) => $this->inGroup(['administrators'], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup([], $who),
                    OrderStatus::Refunded->value  => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle expired transitions
                OrderStatus::Expired->value => [
                    OrderStatus::Pending->value   => fn ($model, $who) => $this->inGroup(['administrators', 'users'], $who),
                    OrderStatus::Refunded->value  => fn ($model, $who) => $this->inGroup(['administrators', 'users'], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle cancelled transitions
                OrderStatus::Cancelled->value => [
                    OrderStatus::Refunded->value => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle refunded transitions
                OrderStatus::Refunded->value => [],

                // handle completed transitions
                OrderStatus::Completed->value => [],

            ];
        } elseif (isset($this->model->order_type) && $this->model->order_type === 'reservation') {
            return [

                // handle pending transitions
                OrderStatus::Pending->value => [

                    OrderStatus::Accepted->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
                    OrderStatus::Rejected->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),

                    OrderStatus::Expired->value   => fn ($model, $who) => $this->inGroup([], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', 'administrators'], $who),
                ],

                // handle preparing transitions
                OrderStatus::Accepted->value => [
                    OrderStatus::Completed->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who)
                ],

                // handle rejected transitions
                OrderStatus::Rejected->value => [
                    OrderStatus::Pending->value   => fn ($model, $who) => $this->inGroup(['administrators'], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup([], $who),
                    OrderStatus::Refunded->value  => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle expired transitions
                OrderStatus::Expired->value => [
                    OrderStatus::Pending->value   => fn ($model, $who) => $this->inGroup(['administrators', 'users'], $who),
                    OrderStatus::Refunded->value  => fn ($model, $who) => $this->inGroup(['administrators', 'users'], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle cancelled transitions
                OrderStatus::Cancelled->value => [
                    OrderStatus::Refunded->value => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle refunded transitions
                OrderStatus::Refunded->value => [],

                // handle completed transitions
                OrderStatus::Completed->value => [],

            ];
        } else {
            return [

                // handle pending transitions
                OrderStatus::Pending->value => [
                    OrderStatus::Preparing->value => function ($model, $who) {
                        if ($model->deliver_type === 'delivery' && $model->driver_id === null) {
                            return false;
                        }

                        return $this->inGroup(['managers', 'administrators', 'partners'], $who);
                    },
                    OrderStatus::Rejected->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),

                    OrderStatus::Expired->value   => fn ($model, $who) => $this->inGroup([], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', 'administrators'], $who),
                ],

                // handle preparing transitions
                OrderStatus::Preparing->value => [
                    OrderStatus::Prepared->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
                    OrderStatus::Rejected->value => fn ($model, $who) => $this->inGroup(['administrators'], $who),

                ],

                // handle prepared transitions
                OrderStatus::Prepared->value => [
                    OrderStatus::Completed->value  => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who) && $model->deliver_type === 'receipt',
                    OrderStatus::InDelivery->value => fn ($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type === 'delivery',

                    OrderStatus::Preparing->value => fn ($model, $who) => $this->inGroup(['administrators'], $who),
                    OrderStatus::Rejected->value  => fn ($model, $who) => $this->inGroup(['administrators'], $who),

                ],

                // handle in delivery transitions
                OrderStatus::InDelivery->value => [
                    OrderStatus::InLocation->value => fn ($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type === 'delivery',

                    OrderStatus::Prepared->value  => fn ($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type === 'delivery',
                    OrderStatus::Preparing->value => fn ($model, $who) => $this->inGroup(['administrators'], $who),
                    OrderStatus::Rejected->value  => fn ($model, $who) => $this->inGroup(['administrators'], $who),

                ],

                // handle in location transitions
                OrderStatus::InLocation->value => [
                    OrderStatus::Completed->value => fn ($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type === 'delivery',

                    OrderStatus::InDelivery->value => fn ($model, $who) => $this->inGroup(['opertional', 'administrators', 'drivers'], $who) && $model->deliver_type === 'delivery',
                    OrderStatus::Rejected->value   => fn ($model, $who) => $this->inGroup(['administrators'], $who),

                ],

                // handle rejected transitions
                OrderStatus::Rejected->value => [
                    OrderStatus::Pending->value   => fn ($model, $who) => $this->inGroup(['administrators'], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup([], $who),
                    OrderStatus::Refunded->value  => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle expired transitions
                OrderStatus::Expired->value => [
                    OrderStatus::Pending->value   => fn ($model, $who) => $this->inGroup(['administrators', 'users'], $who),
                    OrderStatus::Refunded->value  => fn ($model, $who) => $this->inGroup(['administrators', 'users'], $who),
                    OrderStatus::Cancelled->value => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle cancelled transitions
                OrderStatus::Cancelled->value => [
                    OrderStatus::Refunded->value => fn ($model, $who) => $this->inGroup([], $who),
                ],

                // handle refunded transitions
                OrderStatus::Refunded->value => [],

                // handle completed transitions
                OrderStatus::Completed->value => [],

            ];
        }
    }
}
