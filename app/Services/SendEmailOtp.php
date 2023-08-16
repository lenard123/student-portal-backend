<?php

namespace App\Services;

use App\Mail\EmailVerificationOtp;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendEmailOtp
{

    const OTP_EXPIRATION = 60 * 60 * 10; //in seconds = 10minutes

    public function send(string $email)
    {
        $code = Cache::remember("otp:$email", self::OTP_EXPIRATION, function () {
            return $this->generateUniqueCode();
        });

        Mail::to($email)->send(new EmailVerificationOtp($code));
    }

    public function verify(string $email, string $code)
    {
        return $code == Cache::get("otp:$email");
    }

    private function generateUniqueCode()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }

        return $code;
    }
}
