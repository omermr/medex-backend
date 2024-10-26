<?php

namespace App\Services;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponse;

class AuthService extends BaseService
{
    use HttpResponse;

    protected $socialAuthService;
    protected $userService;
    protected $otpService;
    public function __construct(SocialAuthService $socialAuthService, UserService $userService, OTPService $otpService)
    {
        $this->socialAuthService = $socialAuthService;
        $this->userService = $userService;
        $this->otpService = $otpService;
    }

    public function redirect($provider)
    {
        return $this->socialAuthService->redirect($provider);
    }

    public function callback($provider)
    {
        return $this->socialAuthService->callback($provider);
    }

    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            $user   = Auth::user();
            $token  = $user->createToken('API Token')->plainTextToken;
            return $this->success([
                '_token'        => $token,
                'is_verified'   => $user->email_verified_at ? true : false
            ], 'User logged in successfully');
        }

        return $this->error(['_token' => null], 'Invalid credentials', 401);
    }

    public function logout()
    {
        $user = Auth::user();

        if($user) {
            $user->currentAccessToken()->delete();
            Auth::logout();
            return $this->success([], 'User logged out successfully');
        }

        return $this->error([], 'Unable to log out, user not authenticated', 401);
    }

    public function register(array $data)
    {
        return $this->userService->create($data);
    }

    public function requestPasswordReset(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->error(['user' => null], 'User not found', 404);
        }

        return $this->otpService->sendOTP($user, 'password_reset');
    }

    public function resetPassword(string $email, string $otp, string $newPassword)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->error(['user' => null], 'User not found', 404);
        }

        if (!$this->otpService->verify($user, $otp, 'password_reset')) {
            return $this->error(['otp' => null], 'Invalid or expired OTP', 400);
        }

        $user->update(['password' => bcrypt($newPassword)]);

        return $this->success([], 'Password reset successfully');
    }

    public function activateAccount(string $token)
    {
        return $this->userService->activateAccount($token);
    }

    public function sendVerificationCode(array $data)
    {
        return $this->otpService->sendOTP($data, OTP::EMAIL_VERIFICATION);
    }

    public function verifyVerificationCode(array $data)
    {
        return $this->otpService->verify($data['otp'], OTP::EMAIL_VERIFICATION);
    }
}
