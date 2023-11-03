<?php

namespace Saham\SharedLibs\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasWallet
{
    public function deposit(int|float $amount): float|int
    {
        $this->throwExceptionIfAmountIsInvalid($amount);

        $balance = $this->wallet ?? 0;

        $balance += $amount;

        $this->forceFill(['wallet' => $balance])->save();

        return $balance;
    }

    public function withdraw(int|float $amount): float|int
    {
        $this->throwExceptionIfAmountIsInvalid($amount);

        // $this->throwExceptionIfFundIsInsufficient($amount);

        $balance = $this->wallet - $amount;

        $this->forceFill(['wallet' => $balance])->save();

        return $balance;
    }

    public function canWithdraw(int|float $amount): bool
    {
        $this->throwExceptionIfAmountIsInvalid($amount);

        $balance = $this->wallet ?? 0;

        return round($balance, 2) >= round($amount, 2);
    }

    public function balance(): Attribute
    {
        return Attribute::get(fn() => $this->wallet ?? 0);
    }

    public function throwExceptionIfAmountIsInvalid(int|float $amount): void
    {
        if ($amount <= 0) {
            //throw new InvalidAmountException();
        }
    }

    public function throwExceptionIfFundIsInsufficient(int|float $amount): void
    {
        if (!$this->canWithdraw($amount)) {
            //  throw new ResponseException('insufficient_funds', 400);
        }
    }
}
