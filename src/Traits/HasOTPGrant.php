<?php

namespace Saham\SharedLibs\Traits;

use League\OAuth2\Server\Exception\OAuthServerException;

trait HasOTPGrant
{
    public $phoneNumberColumn = 'phone';

    protected function getPhoneNumberColumn(): string
    {
        return $this->phoneNumberColumn;
    }

    public $OTPColumn = 'otp';

    protected function getOTPColumn(): string
    {
        return $this->OTPColumn;
    }

    public $OTPExpireTime = 15;

    protected function getOTPExpireTime(): int
    {
        return $this->OTPExpireTime;
    }

    /**
     * @param $phoneNumber
     * @param $otp
     */
    public function validateForOTPCodeGrant($phoneNumber, $otp): mixed
    {
        $user = $this->where($this->getPhoneNumberColumn(), $phoneNumber)->first();

        if (!$user) {
            throw OAuthServerException::invalidRequest('phone_number', 'phone_number');
        }

        if (!$user->otp || intval($user->otp) !== intval($otp)) {
            throw OAuthServerException::invalidRequest('otp', 'otp is wrong ');
        }

        // if ($user->updated_at->diff(now())->format('%i min') > $this->getOTPExpireTime()) {
        //     throw  OAuthServerException::invalidRequest('otp', 'otp code expired try  get it  again');
        // }

        $this->removeOtp($user);

        return $user;
    }

    public function removeOtp($user): void
    {
        $user->save([$this->getOTPColumn() => null]);
    }
}
