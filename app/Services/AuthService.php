<?php

namespace App\Services;

use App\Exceptions\Auth\Login\InvalidPassword;
use App\Exceptions\Auth\Register\UserAlreadyExists;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(string $name, string $email, string $password): User
    {
        if (User::query()->where('email', $email)->count() > 0) {
            throw new UserAlreadyExists();
        }

        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return $user;
    }

    public function login(string $email, string $password): User
    {
        $user = User::query()
            ->where('email', $email)
            ->first();

        if (! Hash::check($password, $user->password)) {
            throw new InvalidPassword();
        }

        return $user;
    }
}
