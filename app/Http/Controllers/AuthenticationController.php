<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\RegistrationRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function redirect($provider)
    {
        return $this->authService->redirect($provider);
    }

    public function callback($provider)
    {
        return $this->authService->callback($provider);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:8',
        ]);

        return $this->authService->login($request->only('email', 'password'));
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function register(RegistrationRequest $request){
        return $this->authService->register($request->validated());
    }

    public function activateAccount($token)
    {
        return $this->authService->activateAccount($token);
    }

    public function sendVerificationCode(Request $request)
    {
        return $this->authService->sendVerificationCode($request->all());
    }

    public function verifyVerificationCode(Request $request)
    {
        return $this->authService->verifyVerificationCode($request->all());
    }
}
