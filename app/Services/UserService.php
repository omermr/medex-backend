<?php

namespace App\Services;

use App\Http\Resources\Frontend\Profile\ProfileResource;
use App\Models\OTP;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function create(array $data, string $role = User::PATIENT)
    {
        try {
            DB::beginTransaction();

            $data['role'] = $role;
            $data['password'] = Hash::make($data['email']);

            $user = User::create($data);
            if ($role == User::PATIENT) {
                $this->otpService->generate($user, OTP::EMAIL_VERIFICATION);
            }

            DB::commit();

            return $this->success(['user' => $user, 'isSuccess' => true], 'Check your email for OTP verification!');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage(), 422);
        }
    }

    public function updateUserProfile(array $data, int $userId = null)
    {
        try {
            $user = User::find($userId ?? Auth::guard('sanctum')->id());
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

    public function getUserProfile()
    {
        return $this->success(['user' => new ProfileResource(Auth::guard('sanctum')->user()), 'isSuccess' => true], "User profile fetched successfully!");
    }
}

