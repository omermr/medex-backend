<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthService extends BaseService
{
    protected $providers = ['facebook', 'google', 'instagram'];

    public function redirect($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return $this->error(['error' => 'Unsupported provider'], "Something went wrong",  400);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return $this->error(['error' => 'Unsupported provider'], "Something went wrong",  400);
        }

        $socialUser = Socialite::driver($provider)->stateless()->user();
        return $this->findOrCreateUser($socialUser, $provider);
    }

    protected function findOrCreateUser($socialUser, $provider)
    {
        $user = User::where('provider_id', $socialUser->id)->first();
        if (!$user) {
            $user = User::where('email', $socialUser->email)->first();

            if ($user) {
                $user->update([
                    'provider'      => $provider,
                    'provider_id'   => $socialUser->id,
                    'avatar'        => $socialUser->avatar,
                ]);
            } else {
                $user = User::create([
                    'name'          => $socialUser->name,
                    'email'         => $socialUser->email,
                    'provider'      => $provider,
                    'provider_id'   => $socialUser->id,
                    'avatar'        => $socialUser->avatar,
                    'password'      => Hash::make(Str::random(12)),
                ]);
            }
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->success([
            '_token' => $token,
            'is_verified' => $user->email_verified_at ? true : false
        ], "User logged in successfully");
    }
}
