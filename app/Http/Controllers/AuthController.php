<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class AuthController
{
    public function __construct(
        protected AuthService $authService,
    ) {}
    
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register(
            name: $request->name,
            email: $request->email,
            password: $request->password,
        );

        $token = $user->createToken('api');

        return response([
            'token' => $token->plainTextToken,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login(
            email: $request->email,
            password: $request->password,
        );

        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token = $user->tokens->first();

        if (is_null($token)) {
            $token = $user->createToken('api');
        }

        return response([
            'token' => $token->plainTextToken,
        ]);
    }
}
