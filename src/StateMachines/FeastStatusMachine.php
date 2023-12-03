<?php

namespace Saham\SharedLibs\StateMachines;

use Saham\SharedLibs\Models\Enums\FeastStatus;

class FeastStatusMachine extends BaseStateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    /**
     * set default status of newly created models
     */
    public function defaultState(): ?string
    {
        return FeastStatus::Pending->value;
    }

    /**
     * define list of available transitions
     * @return array<string,array<string,callable>>
     */
    public function transitions(): array
    {
        return [
            // from => to pattern
            '*' => [
                FeastStatus::Pending->value => static fn ($model, $who) => true,
            ],

            // handle pending transitions
            FeastStatus::Pending->value => [
                FeastStatus::Approved->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who) && $model->invoice_id !== null,
                FeastStatus::Rejected->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),

                FeastStatus::Expired->value => fn ($model, $who) => $this->inGroup([], $who),
                FeastStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', 'administrators'], $who),
            ],

            // handle approved transitions
            FeastStatus::Approved->value => [
                FeastStatus::Rejected->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),
                FeastStatus::Cancelled->value => fn ($model, $who) => $this->inGroup(['users', 'administrators'], $who),
                FeastStatus::Payed->value => fn ($model, $who) => $this->inGroup(['users'], $who),
            ],

            // handle payed transitions
            FeastStatus::Payed->value => [
                FeastStatus::Preparing->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),

            ],



            // handle preparing transitions
            FeastStatus::Preparing->value => [
                FeastStatus::Prepared->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),

            ],

            // handle prepared transitions
            FeastStatus::Prepared->value => [
                FeastStatus::InLocation->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who)  ,


                FeastStatus::Preparing->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),

            ],


            // handle in location transitions
            FeastStatus::InLocation->value => [
                FeastStatus::Prepared->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who),

                FeastStatus::Completed->value => fn ($model, $who) => $this->inGroup(['managers', 'administrators', 'partners'], $who)  ,

             ],

            // handle rejected transitions
            FeastStatus::Rejected->value => [
                FeastStatus::Cancelled->value => fn ($model, $who) => $this->inGroup([], $who),
                FeastStatus::Refunded->value => fn ($model, $who) => $this->inGroup([], $who),
                FeastStatus::Pending->value => fn ($model, $who) => $this->inGroup(['administrators'], $who),
            ],

            // handle expired transitions
            FeastStatus::Expired->value => [
                FeastStatus::Cancelled->value => fn ($model, $who) => $this->inGroup([], $who),
                FeastStatus::Pending->value => fn ($model, $who) => $this->inGroup(['administrators', 'users'], $who),
                FeastStatus::Refunded->value => fn ($model, $who) => $this->inGroup(['administrators', 'users'], $who),
            ],

            // handle cancelled transitions
            FeastStatus::Cancelled->value => [
                FeastStatus::Refunded->value => fn ($model, $who) => $this->inGroup([], $who),
            ],

            // handle refunded transitions
            FeastStatus::Refunded->value => [],

            // handle completed transitions
            FeastStatus::Completed->value => [],

        ];
    }
}
