<?php

namespace App\Services;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendMailJob;

class OTPService extends BaseService
{
    public function generate($data, $type, int $expiryMinutes = 15)
    {
        $user   = Auth::guard('sanctum')->user();
        $otp    = Str::random(6);

        OTP::create([
            'user_id'       => $user->id,
            'otp'           => $otp,
            'type'          => $type,
            'expires_at'    => now()->addMinutes($expiryMinutes),
        ]);

        $subject = 'OTP Verification';
        $view    = 'emails.otp';
        $data    = ['name' => $user->name, 'otp' => $otp];

        SendMailJob::dispatch($user->email, $subject, $view, $data);

        return $this->success(['isSuccess' => true], 'OTP generated successfully');
    }

    public function verify(string $otp, string $type)
    {
        $user = Auth::guard('sanctum')->user();
        $otpRecord = OTP::where('user_id', $user->id)
                       ->where('otp', $otp)
                       ->where('type', $type)
                       ->where('is_used', false)
                       ->where('expires_at', '>', now())
                       ->first();

        if (!$otpRecord) {
            return $this->error(['isSuccess' => false], 'Invalid OTP', 400);
        }

        $user->update([
            'status' => User::ACTIVE,
            'email_verified_at' => now(),
        ]);

        $otpRecord->update(['is_used' => true]);
        return $this->success(['is_verified' => true, 'isSuccess' => true], 'OTP verified successfully');
    }

    public function sendOTP($data, string $type)
    {
        return $this->generate($data, $type);
    }
}
