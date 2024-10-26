<?php

namespace App\Services;

use App\Http\Resources\Frontend\Profile\ProfileResource;
use App\Models\OTP;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            $data['type'] = User::PATIENT;
            $user = User::create($data);
            $this->otpService->generate($user, OTP::EMAIL_VERIFICATION);

            DB::commit();

            return $this->success(['isSuccess' => true], 'Check your email for OTP verification!');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage(), 422);
        }
    }

    public function updateUserProfile(array $data)
    {
        try {
            $user = User::find(Auth::guard('sanctum')->id());
            $user->update($data);

            return $this->success(['user' => new ProfileResource($user), 'isSuccess' => true], "User updated successfully!");
        } catch (\Exception $e) {
            return $this->error(['isSuccess' => false], $e->getMessage(), 422);
        }
    }

    public function activateAccount(string $token)
    {
        return User::where('activation_token', $token)->first()->update(['status' => 'active']);
    }
}

