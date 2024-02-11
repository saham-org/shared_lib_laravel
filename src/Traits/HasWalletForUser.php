<?php

namespace Saham\SharedLibs\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Saham\SharedLibs\Models\Wallet;

trait HasWalletForUser
{
    public function deposit(int|float $amount): float|int
    {
        if ($this->wallet === null) {
            $this->load('wallet');
        }
        $this->throwExceptionIfAmountIsInvalid($amount);

        $balance = $this->wallet->wallet ?? 0;

        $balance += $amount;


        $this->wallet->update(['wallet' => $balance]);
        // $this->forceFill(['wallet' => $balance])->save();

        return $balance;
    }

    public function withdraw(int|float $amount): float|int
    {
        $this->throwExceptionIfAmountIsInvalid($amount);

        // $this->throwExceptionIfFundIsInsufficient($amount);
        if ($this->wallet === null) {
            $this->load('wallet');
        }

        $balance = $this->wallet->wallet - $amount;

        $this->wallet->update(['wallet' => $balance]);


        return $balance;
    }

    public function canWithdraw(int|float $amount): bool
    {
        $this->throwExceptionIfAmountIsInvalid($amount);

        if($this->wallet === null){
            $this->load('wallet');
        
         }
         
        $balance = $this->wallet->wallet ?? 0;

        return round($balance, 2) >= round($amount, 2);
    }

    public function balance(): Attribute
    {
        if($this->wallet === null){
            $this->load('wallet');
        
         }
         
        return Attribute::get(fn () => $this->wallet->wallet ?? 0);
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